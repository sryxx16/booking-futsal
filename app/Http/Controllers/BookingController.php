<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\AddOn;
use App\Models\PromoCode; // <-- Ini udah gw tambahin bang
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Menampilkan semua booking (Untuk Admin)
        $bookings = Booking::with(['user', 'field', 'schedules'])->get();
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
        // 1. Validasi Inputan User (Ubah schedule_id jadi array schedules)
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date|after_or_equal:today',
            'schedules' => 'required|array|min:1',
            'schedules.*' => 'exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'promo_code' => 'nullable|string|exists:promo_codes,code', // Tambah ini bang
        ], [
            'schedules.required' => 'Lu belum milih jam mainnya bang!',
            'schedules.min' => 'Minimal pilih 1 jadwal jam tayang.',
            'booking_name.required' => 'Nama tim atau pemesan wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp wajib diisi buat dihubungin admin.'
        ]);

        // 2. Cek apakah ada jadwal dalam array yang udah dibooking orang di detik yang sama
        // (Asumsi sistem Abang: jadwal laku = is_available false)
        $clashingSchedules = Schedule::whereIn('id', $request->schedules)
                                     ->where('is_available', false)
                                     ->exists();

        if ($clashingSchedules) {
            return back()->withErrors(['Wah telat nih! Salah satu jadwal yang dipilih baru saja dibooking orang lain. Silakan pilih jadwal yang lain.']);
        }

        // 3. LOGIKA PROMO: Hitung diskon sebelum simpan booking
        $discountAmount = 0;
        $field = Field::find($request->field_id);
        $totalBasePrice = count($request->schedules) * $field->price_per_hour;

        if ($request->promo_code) {
            // Cari promo code di database
            $promo = PromoCode::where('code', $request->promo_code)
                              ->where('is_active', true)
                              ->where('valid_until', '>=', now())
                              ->first();

            if ($promo) {
                // Hitung diskon berdasarkan tipe
                if ($promo->type === 'percentage') {
                    $discountAmount = ($totalBasePrice * $promo->value) / 100;
                } else {
                    $discountAmount = $promo->value;
                }
            }
        }


        // 4. Simpan ke Database (1 Invoice + Diskon)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'field_id' => $request->field_id,
            'booking_name' => $request->booking_name,
            'phone_number' => $request->phone_number,
            'status' => 'pending',
            'discount_amount' => $discountAmount, // Simpan diskonnya di sini bang!
            'expired_at' => now()->addHours(2),
        ]);

        // Iket semua jadwal ke pivot table
        $booking->schedules()->attach($request->schedules);

        // Tandai jadwal jadi Booked
        Schedule::whereIn('id', $request->schedules)->update(['is_available' => false]);

        return redirect()->route('user.administration.index')->with('success', 'Booking berhasil diamankan! Silakan segera lakukan pembayaran.');
    }

    public function edit(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini.');
        }

        $booking = $booking->load('schedules'); // Ubah dari schedule ke schedules
        $fields = Field::all();
        $schedules = Schedule::all();
        return view('admin.bookings.edit', compact('booking', 'fields', 'schedules'));
    }

    public function update(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate booking ini.');
        }

        // Asumsi admin juga bisa mengedit jadwal jadi multiple via array
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedules' => 'required|array|min:1',
            'schedules.*' => 'exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'status' => 'required|in:pending,confirmed,completed,canceled',
        ]);

        // Lepas status booked dari jadwal-jadwal lama
        foreach ($booking->schedules as $oldSchedule) {
            $oldSchedule->update(['is_available' => true]);
        }

        $booking->update([
            'field_id' => $validated['field_id'],
            'booking_name' => $validated['booking_name'],
            'phone_number' => $validated['phone_number'],
            'status' => $validated['status'],
        ]);

        // Iket dengan jadwal yang baru dipilih admin
        $booking->schedules()->sync($validated['schedules']);

        // Ubah ketersediaan jadwal berdasarkan status booking
        foreach ($booking->schedules as $newSchedule) {
            if (in_array($validated['status'], ['pending', 'confirmed'])) {
                $newSchedule->update(['is_available' => false]);
                if($validated['status'] == 'confirmed') {
                    $booking->update(['expired_at' => null]);
                }
            } else {
                $newSchedule->update(['is_available' => true]);
            }
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui');
    }

    public function destroy(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk menghapus booking ini.');
        }

        // Buka kembali semua jadwal sebelum booking dihapus
        foreach ($booking->schedules as $schedule) {
            $schedule->update(['is_available' => true]); // Bug null date udah diperbaiki
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

        // UBAHAN SAKTI: Pakai whereDate biar lebih aman ngebaca format tanggal apapun dari database
        $schedules = Schedule::where('field_id', $validated['field_id'])
                            ->whereDate('date', $validated['date'])
                            ->orderBy('start_time')
                            ->get();

        $schedules->map(function($schedule) {
            $schedule->is_booked = !$schedule->is_available;
            return $schedule;
        });

        return response()->json($schedules);
    }

    public function indexBookingsUser()
    {
        // Ubah relasi dari 'schedule' menjadi 'schedules'
        $bookings = Booking::with(['field', 'schedules', 'payment'])
                           ->where('user_id', Auth::id())
                           ->latest()
                           ->get();

        foreach ($bookings as $booking) {
            if ($booking->payment && $booking->payment->status == 'paid') {
                $booking->expired_at_display = '-';
            } elseif ($booking->payment && $booking->payment->status == 'failed') {
                foreach ($booking->schedules as $schedule) {
                    $schedule->update(['is_available' => true]);
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
                    foreach ($booking->schedules as $schedule) {
                        $schedule->update(['is_available' => true]);
                    }
                    $booking->expired_at_display = 'Expired';
                } else {
                    $booking->expired_at_display = Carbon::parse($booking->expired_at)->diffForHumans();
                }
            }
        }

        return view('user.administration.index', compact('bookings'));
    }

    public function cancel($bookingId)
    {
        $booking = Booking::with('schedules')->find($bookingId);

        if (!$booking || $booking->user_id !== auth()->id()) {
            return redirect()->route('user.administration.index')->with('error', 'Booking tidak ditemukan atau Anda tidak memiliki izin untuk membatalkannya.');
        }

        $booking->update(['status' => 'canceled']);

        foreach ($booking->schedules as $schedule) {
            $schedule->update(['is_available' => true]);
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
        $booking = Booking::with('schedules')->find($bookingId);
        if ($booking && $booking->status == 'pending') {
            $booking->update(['status' => 'canceled']);
            foreach ($booking->schedules as $schedule) {
                $schedule->update(['is_available' => true]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function getAvailableSchedulesByDate(Request $request)
    {
        try {
            $request->validate(['date' => 'required|date']);

            $daysMapping = [
                'Sunday'    => 'Minggu', 'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',  'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu'
            ];

            $englishDay = Carbon::parse($request->date)->format('l');
            $day = $daysMapping[$englishDay];

            $fields = Field::all();
            $result = [];

            foreach ($fields as $field) {
                $schedules = Schedule::where('field_id', $field->id)
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
        $bookings = Booking::with(['field', 'schedules'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('user.administration.index', compact('bookings'));
}

    // --- FUNGSI CEK PROMO VIA AJAX (VERSI ANTI-BADAI) ---
    public function checkPromo(Request $request)
    {
        try {
            // Kita cari promonya (tanpa where valid_until dulu biar ga error kalau kolomnya ga ada)
            $promo = \App\Models\PromoCode::where('code', $request->code)->first();

            if ($promo) {
                // Kita cek manual ketersediaannya (Biar aman dari error kolom tidak ditemukan)
                $isActive = isset($promo->is_active) ? $promo->is_active : true;

                $isValidDate = true;
                if (isset($promo->valid_until) && $promo->valid_until < now()) {
                    $isValidDate = false;
                }

                if ($isActive && $isValidDate) {
                    return response()->json([
                        'valid' => true,
                        'promo' => [
                            'id' => $promo->id,
                            'code' => $promo->code,
                            'type' => $promo->type,
                            'value' => $promo->value
                        ],
                        'message' => 'Kode promo berhasil digunakan!',
                        'discount_label' => $promo->type === 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.')
                    ]);
                } else {
                    return response()->json([
                        'valid' => false,
                        'message' => 'Kode promo tidak aktif atau kedaluwarsa.'
                    ]);
                }
            }

            return response()->json([
                'valid' => false,
                'message' => 'Kode promo tidak ditemukan.'
            ]);

        } catch (\Exception $e) {
            // NAH! Kalau ada error dari Laravel, bakal langsung dikirim ke layar abang
            return response()->json([
                'valid' => false,
                'message' => 'Error Sistem: ' . $e->getMessage()
            ]);
        }
    }
}