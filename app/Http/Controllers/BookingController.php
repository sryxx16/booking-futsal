<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\AddOn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Menampilkan semua booking (Untuk Admin)
        $bookings = Booking::all();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $fields = Field::all();
        $schedules = Schedule::where('is_available', true)->get();
        $addOns = AddOn::where('stock', '>', 0)->get();

        return view('admin.bookings.create', compact('users','fields', 'schedules', 'addOns'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date|after_or_equal:today',
            'schedules' => 'required|array|min:1',
            'schedules.*' => 'exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'promo_code' => 'nullable|string' // Validasi promo
        ]);

        $clashingSchedules = Schedule::whereIn('id', $request->schedules)
                                     ->where('is_available', false)
                                     ->exists();

        if ($clashingSchedules) {
            return back()->withErrors(['Wah telat nih! Salah satu jadwal yang dipilih baru saja dibooking orang lain.']);
        }

        // --- PROSES HITUNG DISKON SEBELUM MASUK DATABASE ---
        $promoId = null;
        $discountPerBooking = 0;

        if ($request->filled('promo_code')) {
            $promo = \App\Models\PromoCode::where('code', strtoupper($request->promo_code))->first();

            // Pastikan promo valid
            if ($promo && $promo->is_active && !\Carbon\Carbon::parse($promo->valid_until)->isPast() && $promo->used_count < $promo->quota) {
                $promoId = $promo->id;
                $field = \App\Models\Field::find($request->field_id);

                $subtotal = count($request->schedules) * $field->price_per_hour;
                $totalDiscount = 0;

                if ($promo->type == 'percentage') {
                    $totalDiscount = $subtotal * ($promo->value / 100);
                } else {
                    $totalDiscount = $promo->value;
                }

                // Dibagi rata ke setiap invoice jam
                $discountPerBooking = $totalDiscount / count($request->schedules);

                $promo->increment('used_count');
            }
        }
        // ----------------------------------------------------

        // Simpan ke Database
        foreach ($request->schedules as $schedule_id) {
            Booking::create([
                'user_id' => Auth::id(),
                'field_id' => $request->field_id,
                'schedule_id' => $schedule_id,
                'booking_name' => $request->booking_name,
                'phone_number' => $request->phone_number,
                'promo_code_id' => $promoId,              // Simpan ID Promo
                'discount_amount' => $discountPerBooking, // Simpan potongan harganya!
                'status' => 'pending',
                'expired_at' => now()->addHours(2),
            ]);

            Schedule::where('id', $schedule_id)->update(['is_available' => false]);
        }

        return redirect()->route('user.administration.index')->with('success', 'Booking berhasil diamankan! Silakan segera lakukan pembayaran.');
    }

    public function edit(Booking $booking)
    {
        // Pastikan hanya user terkait yang dapat mengedit atau admin
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini.');
        }

        $booking = $booking->load('schedule');
        $fields = Field::all();
        $schedules = Schedule::all();
        return view('admin.bookings.edit', compact('booking', 'fields', 'schedules'));
    }

    public function update(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate booking ini.');
        }

        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'status' => 'required|in:pending,confirmed,completed,canceled',
        ]);

        if ($booking->schedule_id !== $validated['schedule_id']) {
            $oldSchedule = Schedule::find($booking->schedule_id);
            if ($oldSchedule) {
                $oldSchedule->update(['is_available' => true]);
            }
        }

        $booking->update($validated);

        $schedule = Schedule::find($validated['schedule_id']);
        if ($schedule) {
            switch ($validated['status']) {
                case 'pending':
                case 'confirmed':
                    $booking->update([
                        'status' => 'confirmed',
                        'expired_at' => null,
                    ]);
                    $schedule->update(['is_available' => false]);
                    break;
                case 'completed':
                case 'canceled':
                    $schedule->update(['is_available' => true]);
                    break;
            }
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui');
    }

    public function destroy(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk menghapus booking ini.');
        }

        $schedule = Schedule::find($booking->schedule_id);
        if ($schedule) {
            $schedule->update([
                'is_available' => true,
                'date' => null,
            ]);
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus');
    }

    public function getSchedules(Request $request)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date',
        ]);

        // Cari berdasarkan TANGGAL yang diklik user, bukan sekadar nama hari
        $schedules = \App\Models\Schedule::where('field_id', $validated['field_id'])
                            ->where('date', $validated['date'])
                            ->orderBy('start_time')
                            ->get();

        // Manipulasi data buat ngasih tau frontend mana yang udah laku
        $schedules->map(function($schedule) {
            // Kalau is_available di database false, berarti is_booked = true
            $schedule->is_booked = !$schedule->is_available;
            return $schedule;
        });

        return response()->json($schedules);
    }

    // FUNGSI INI YANG DIPAKAI BUAT NAMPILIN RIWAYAT PESANAN USER
    public function indexBookingsUser()
    {
        // Ambil semua booking beserta relasinya, urutkan dari yang terbaru
        $bookings = Booking::with(['field', 'schedule', 'payment'])
                           ->where('user_id', Auth::id())
                           ->latest()
                           ->get();

        foreach ($bookings as $booking) {
            if ($booking->payment && $booking->payment->status == 'paid') {
                $booking->expired_at_display = '-';
            } elseif ($booking->payment && $booking->payment->status == 'failed') {
                if ($booking->schedule) {
                    $booking->schedule->is_available = true;
                    $booking->schedule->date = null;
                    $booking->schedule->save();
                }
                $booking->status = 'canceled';
                $booking->save();
                $booking->expired_at_display = 'Pembayaran Gagal';
            } elseif ($booking->payment && $booking->payment->status == 'checked') {
                $booking->expired_at_display = 'Mengecek Pembayaran';
            } else {
                if ($booking->status === 'confirmed') {
                    $booking->expired_at_display = '-';
                } elseif (Carbon::parse($booking->expired_at) < now() && $booking->status === 'pending') {
                    $booking->status = 'canceled';
                    $booking->save();
                    if ($booking->schedule) {
                        $booking->schedule->is_available = true;
                        $booking->schedule->save();
                    }
                    $booking->expired_at_display = 'Expired';
                } else {
                    $booking->expired_at_display = Carbon::parse($booking->expired_at)->diffForHumans();
                }
            }
        }

        // Tampilkan ke view
        return view('user.administration.index', compact('bookings'));
    }

    public function cancel($bookingId)
    {
        $booking = Booking::find($bookingId);

        if (!$booking || $booking->user_id !== auth()->id()) {
            return redirect()->route('user.administration.index')->with('error', 'Booking tidak ditemukan atau Anda tidak memiliki izin untuk membatalkannya.');
        }

        $booking->update(['status' => 'canceled']);

        $schedule = Schedule::find($booking->schedule_id);
        if ($schedule) {
            $schedule->update([
                'is_available' => true,
                'date' => null
            ]);
        }

        return redirect()->route('user.administration.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function scheduleDetails($scheduleId)
    {
        $schedule = Schedule::find($scheduleId);
        if ($schedule) {
            return response()->json([
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ]);
        }
        return response()->json(['error' => 'Schedule not found'], 404);
    }

    public function cancelExpiredBooking($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking && $booking->status == 'pending') {
            $booking->update(['status' => 'canceled']);
            $schedule = $booking->schedule;
            if ($schedule) {
                $schedule->update([
                    'is_available' => true,
                    'date' => null
                ]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function getAvailableSchedulesByDate(Request $request)
    {
        try {
            $request->validate(['date' => 'required|date']);

            $daysMapping = [
                'Sunday'    => 'Minggu',
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu'
            ];

            $englishDay = \Carbon\Carbon::parse($request->date)->format('l');
            $day = $daysMapping[$englishDay];

            $fields = \App\Models\Field::all();
            $result = [];

            foreach ($fields as $field) {
                $schedules = \App\Models\Schedule::where('field_id', $field->id)
                    ->where('day', $day)
                    ->where('is_available', true)
                    ->orderBy('start_time')
                    ->get();

                $result[] = [
                    'field_id' => $field->id,
                    'field_name' => $field->name,
                    'price_per_hour' => $field->price_per_hour,
                    'schedules' => $schedules
                ];
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function userIndex()
{
    // Ambil data booking milik user yang sedang login beserta relasinya (lapangan & jadwal)
    $bookings = \App\Models\Booking::with(['field', 'schedule'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('user.administration.index', compact('bookings'));
}
}