<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Helper Baru: Menghitung total harga berdasarkan koleksi schedules (Multiple Hours)
     */
    private function calculateGrandTotal(Booking $booking)
    {
        // 1. Hitung Harga Lapangan (Berdasarkan jumlah jam yang dibooking)
        // Sekarang kita hitung ada berapa banyak jadwal yang terikat (pivot)
        $totalHours = $booking->schedules->count();
        $fieldPrice = $booking->field->price_per_hour * $totalHours;

        // 2. Hitung Harga Fasilitas Tambahan (Add-ons) - Kode tetap aman
        $addOnsPrice = 0;
        if ($booking->addOns) {
            foreach ($booking->addOns as $addon) {
                $addOnsPrice += ($addon->pivot->price * $addon->pivot->quantity);
            }
        }

        // 3. Kurangi Diskon (Promo)
        $discount = $booking->discount_amount ?? 0;

        // 4. Total Akhir
        $totalPrice = ($fieldPrice + $addOnsPrice) - $discount;

        return $totalPrice < 0 ? 0 : $totalPrice;
    }

    public function index()
    {
        // Fix relasi ke schedules agar admin bisa lihat detail jamnya juga
        $payments = Auth::user()->role === 'admin'
            ? Payment::with('booking.schedules')->get()
            : Payment::whereHas('booking', function($q) {
                $q->where('user_id', Auth::id());
            })->with('booking.schedules')->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function create($bookingId)
    {
        // LOAD schedules (Pake 's'), bukan schedule!
        $booking = Booking::with(['field', 'schedules', 'addOns'])->findOrFail($bookingId);

        $totalPrice = $this->calculateGrandTotal($booking);

        return view('admin.payments.create', compact('booking', 'totalPrice'));
    }

    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // LOAD schedules (Pake 's')
        $booking = Booking::with(['field', 'schedules', 'addOns'])->findOrFail($bookingId);

        $totalPrice = $this->calculateGrandTotal($booking);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'status' => 'checked',
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
        ]);

        $booking->update(['status' => 'pending']);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dibuat!');
        } else {
            return redirect()->route('user.administration.index')->with('success', 'Pembayaran berhasil dibuat!');
        }
    }

    public function show(Payment $payment)
    {
        // Load relasi jam agar bisa tampil di detail pembayaran
        $payment->load('booking.schedules');
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $payment->booking->user_id) {
            return redirect()->route('admin.payments.index')->with('error', 'Anda tidak memiliki izin.');
        }
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.payments.index')->with('error', 'Anda tidak memiliki izin.');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,failed,checked',
        ]);

        $oldStatus = $payment->status;

        $payment->update([
            'status' => $request->status,
        ]);

        $booking = $payment->booking;

        if ($request->status === 'paid') {
            $booking->update(['status' => 'confirmed']);
        } elseif ($request->status === 'failed') {
            $booking->update(['status' => 'canceled']);
            // Lepas status booked dari jadwal-jadwalnya jika gagal bayar
            foreach ($booking->schedules as $schedule) {
                $schedule->update(['is_available' => true]);
            }
        }

        \App\Models\ActivityLog::record(
            'Verifikasi Pembayaran',
            "Admin mengubah status pembayaran Booking #{$booking->id} dari '{$oldStatus}' menjadi '{$request->status}'"
        );

        return redirect()->route('admin.payments.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function destroy(Payment $payment)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $payment->booking->user_id) {
            return redirect()->route('admin.payments.index')->with('error', 'Izin ditolak.');
        }

        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}
