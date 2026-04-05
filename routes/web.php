<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\ActivityLogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- AUTH ROUTES ---
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// --- LANDING PAGE ---
Route::get('/', function () {
    $fields = \App\Models\Field::all();
    $weatherController = app(\App\Http\Controllers\WeatherController::class);
    $weatherData = $weatherController->showWeather();
    $setting = \App\Models\Setting::first() ?? new \App\Models\Setting();

    return view('landing-page.index', array_merge([
        'fields' => $fields,
        'setting' => $setting
    ], $weatherData));
})->name('index');

Route::get('/landing-page', [BookingController::class, 'showLandingPage'])->name('landing-page');


// ==========================================
// RUTE USER (PELANGGAN)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // Pengecekan Promo (Bisa diakses user & admin)
    Route::post('/check-promo', [PromoCodeController::class, 'check'])->name('promo.check');

    // Manajemen Booking User
    Route::get('user/administration', [BookingController::class, 'indexBookingsUser'])->name('user.administration.index');
    Route::prefix('user/bookings')->name('user.bookings.')->group(function () {
        Route::get('/getSchedules', [BookingController::class, 'getSchedules'])->name('getSchedules');
        Route::get('/scheduleDetails/{scheduleId}', [BookingController::class, 'scheduleDetails']);
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/store', [BookingController::class, 'store'])->name('store');
        Route::post('/cancel/{bookingId}', [BookingController::class, 'cancel'])->name('cancel');
        Route::post('/cancel/expired/{bookingId}', [BookingController::class, 'cancelExpiredBooking'])->name('cancelExpired');
    });

    // Manajemen Pembayaran User
    Route::get('user/payments', [PaymentController::class, 'userPayments'])->name('user.payments.index');
    Route::get('user/payments/create/{bookingId}', [PaymentController::class, 'create'])->name('user.payments.create');
    Route::post('user/payments/store/{bookingId}', [PaymentController::class, 'store'])->name('user.payments.store');
});


// ==========================================
// RUTE ADMIN
// ==========================================
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Lainnya
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/weather/{city}', [WeatherController::class, 'showWeather']);

    // --- API JADWAL (Harus paling atas biar nggak ketimpa route resource) ---
    Route::get('bookings/getSchedules', [BookingController::class, 'getSchedules'])->name('bookings.getSchedules');
    Route::get('bookings/scheduleDetails/{scheduleId}', [BookingController::class, 'scheduleDetails'])->name('bookings.scheduleDetails');
    Route::get('bookings/getAvailableSchedulesByDate', [BookingController::class, 'getAvailableSchedulesByDate'])->name('bookings.getAvailableSchedulesByDate');


    // Booking
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Lapangan (Fields)
    Route::get('fields', [FieldController::class, 'index'])->name('fields.index');
    Route::get('fields/create', [FieldController::class, 'create'])->name('fields.create');
    Route::post('fields', [FieldController::class, 'store'])->name('fields.store');
    Route::get('fields/{field}', [FieldController::class, 'show'])->name('fields.show');
    Route::get('fields/{field}/edit', [FieldController::class, 'edit'])->name('fields.edit');
    Route::put('fields/{field}', [FieldController::class, 'update'])->name('fields.update');
    Route::delete('fields/{field}', [FieldController::class, 'destroy'])->name('fields.destroy');

    // Jadwal (Schedules)
    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // User
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Pengaturan
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Laporan Keuangan & PDF
    Route::get('laporan-keuangan', [AdminController::class, 'financialReport'])->name('reports.financial');
    Route::get('laporan/export-pdf', [AdminController::class, 'exportPdf'])->name('export.pdf');

    // Promo Codes & Add-ons (Memakai route resource agar praktis)
    Route::resource('promo-codes', PromoCodeController::class);
    Route::resource('add-ons', AddOnController::class);

    // Pembayaran (Payments)
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create/{bookingId}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/{bookingId}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::resource('memberships', MembershipController::class);

Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');});

// --- RUTE BYPASS (DEVELOPMENT) ---
Route::get('/bypass-admin', function () {
    $admin = \App\Models\User::updateOrCreate(
        ['email' => 'superadmin@gmail.com'],
        [
            'name' => 'Super Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('rahasia123'),
            'role' => 'admin'
        ]
    );
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.dashboard');
});
