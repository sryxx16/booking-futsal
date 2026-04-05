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
     * Fungsi bantuan (Helper) untuk menghitung total harga secara akurat
     */
    private function calculateGrandTotal(Booking $booking)
    {
        // 1. Hitung Harga Lapangan (Berdasarkan Durasi)
        $startTime = Carbon::parse($booking->schedule->start_time);
        $endTime = Carbon::parse($booking->schedule->end_time);

        // Hitung selisih jam (minimal 1 jam)
        $durationHours = $endTime->diffInHours($startTime) ?: 1;
        $fieldPrice = $booking->field->price_per_hour * $durationHours;

        // 2. Hitung Harga Fasilitas Tambahan (Add-ons)
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

        // Pastikan total tidak minus
        return $totalPrice < 0 ? 0 : $totalPrice;
    }

    public function index()
    {
        $payments = Auth::user()->role === 'admin' ? Payment::all() : Payment::where('booking_id', Auth::id())->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function create($bookingId)
    {
        // Ambil data booking beserta relasinya
        $booking = Booking::with(['field', 'schedule', 'addOns'])->findOrFail($bookingId);

        // Gunakan helper untuk menghitung harga asli
        $totalPrice = $this->calculateGrandTotal($booking);

        return view('admin.payments.create', compact('booking', 'totalPrice'));
    }

    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $booking = Booking::with(['field', 'schedule', 'addOns'])->findOrFail($bookingId);

        // Gunakan helper untuk menghitung harga asli saat menyimpan
        $totalPrice = $this->calculateGrandTotal($booking);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            // Parameter 'public' memastikan tersimpan di storage/app/public
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice, // Nilai yang tersimpan sekarang 100% akurat
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
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $payment->booking->user_id) {
            return redirect()->route('admin.payments.index')->with('error', 'Anda tidak memiliki izin untuk mengedit pembayaran ini.');
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

        // Simpan status lama buat perbandingan di log
        $oldStatus = $payment->status;

        $payment->update([
            'status' => $request->status,
        ]);

        $booking = $payment->booking;

        if ($request->status === 'paid') {
            $booking->update(['status' => 'confirmed']);
        } elseif ($request->status === 'failed') {
            $booking->update(['status' => 'canceled']);
        }

        // CATAT KE LOG AKTIVITAS (Satu baris ini aja bang magic-nya!)
        \App\Models\ActivityLog::record(
            'Verifikasi Pembayaran',
            "Admin mengubah status pembayaran Booking #{$booking->id} dari '{$oldStatus}' menjadi '{$request->status}'"
        );

        return redirect()->route('admin.payments.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function destroy(Payment $payment)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $payment->booking->user_id) {
            return redirect()->route('admin.payments.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pembayaran ini.');
        }

        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}