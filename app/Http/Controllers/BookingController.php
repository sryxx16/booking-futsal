<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\AddOn;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // --- FUNGSI BARU BIAR HALAMAN DEPAN BISA BACA ADD-ON ---
    public function showLandingPage()
    {
        $fields = Field::all();
        $setting = \App\Models\Setting::first() ?? new \App\Models\Setting();

        $weatherController = app(\App\Http\Controllers\WeatherController::class);
        $weatherData = $weatherController->showWeather();

        // INI DIA KUNCINYA BIAR ROMPI & SEPATU NONGOL DI POP-UP
        $addOns = AddOn::where('stock', '>', 0)->get();

        return view('landing-page.index', array_merge([
            'fields' => $fields,
            'setting' => $setting,
            'addOns' => $addOns // Kita lempar datanya ke tampilan depan!
        ], $weatherData));
    }

    public function index(Request $request)
    {
        // Menampilkan semua booking (Untuk Admin) dengan relasi komplit
        $query = Booking::with(['user', 'field', 'schedules', 'payment', 'addOns']);

        // LOGIKA FILTER TANGGAL
        if ($request->has('date') && $request->date != '') {
            // Filter booking yang punya jadwal di tanggal yang dicari
            $query->whereHas('schedules', function($q) use ($request) {
                $q->whereDate('date', $request->date);
            });
        }

        $bookings = $query->latest()->get();
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
            'promo_code' => 'nullable|string|exists:promo_codes,code',
            // Tambahin validasi add_ons
            'add_ons' => 'nullable|array',
            'add_ons.*.id' => 'exists:add_ons,id',
            'add_ons.*.quantity' => 'integer|min:1',
        ], [
            'schedules.required' => 'Lu belum milih jam mainnya bang!',
            'booking_name.required' => 'Nama tim atau pemesan wajib diisi.',
        ]);

        $clashingSchedules = Schedule::whereIn('id', $request->schedules)
                                     ->where('is_available', false)
                                     ->exists();

        if ($clashingSchedules) {
            return back()->withErrors(['Wah telat nih! Salah satu jadwal yang dipilih baru saja dibooking orang lain.']);
        }

        // Hitung Harga Lapangan
        $field = Field::find($request->field_id);
        $fieldPrice = count($request->schedules) * $field->price_per_hour;

        // Hitung Harga Add-ons
        $addOnsPrice = 0;
        if ($request->has('add_ons')) {
            foreach ($request->add_ons as $addon) {
                if (isset($addon['id'])) {
                    $addonModel = \App\Models\AddOn::find($addon['id']);
                    if($addonModel) {
                        $addOnsPrice += $addonModel->price * ($addon['quantity'] ?? 1);
                    }
                }
            }
        }

        // Total sebelum diskon (Lapangan + Fasilitas)
        $totalBasePrice = $fieldPrice + $addOnsPrice;
        $discountAmount = 0;

        if ($request->promo_code) {
            $promo = \App\Models\PromoCode::where('code', $request->promo_code)
                              ->where('is_active', true)
                              ->where('valid_until', '>=', now())
                              ->first();

            if ($promo) {
                if ($promo->type === 'percentage') {
                    $discountAmount = ($totalBasePrice * $promo->value) / 100;
                } else {
                    $discountAmount = $promo->value;
                }
                if ($discountAmount > $totalBasePrice) $discountAmount = $totalBasePrice;
            }
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'field_id' => $request->field_id,
            'booking_name' => $request->booking_name,
            'phone_number' => $request->phone_number,
            'status' => 'pending',
            'discount_amount' => $discountAmount,
            'expired_at' => now()->addHours(2),
        ]);

        $booking->schedules()->attach($request->schedules);
        Schedule::whereIn('id', $request->schedules)->update(['is_available' => false]);

        // SIMPAN DATA ADD-ONS KE DATABASE (Pivot Table)
        if ($request->has('add_ons')) {
            $addOnsData = [];
            foreach ($request->add_ons as $addon) {
                if (isset($addon['id'])) {
                    $addonModel = \App\Models\AddOn::find($addon['id']);
                    if($addonModel) {
                        $addOnsData[$addon['id']] = [
                            'quantity' => $addon['quantity'] ?? 1,
                            'price' => $addonModel->price
                        ];
                    }
                }
            }
            $booking->addOns()->attach($addOnsData);
        }

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
            $schedule->update(['is_available' => true]);
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

        // Pakai whereDate biar aman ngebaca format tanggal apapun dari database
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
            $promo = \App\Models\PromoCode::where('code', $request->code)->first();

            if ($promo) {
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
            return response()->json([
                'valid' => false,
                'message' => 'Error Sistem: ' . $e->getMessage()
            ]);
        }
    }
}