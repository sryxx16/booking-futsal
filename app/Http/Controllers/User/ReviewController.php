<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        // 1. Pastikan yang ngereview adalah yang punya bookingan
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // 2. Cek apakah user udah pernah ngasih ulasan buat ID booking ini
        // Biar ga bisa dispam berkali-kali
        if (Review::where('booking_id', $booking->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        // 3. Validasi inputan bintang dan teksnya
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // 4. Simpan ke database (status otomatis is_approved = false)
        Review::create([
            'user_id' => Auth::id(),
            'field_id' => $booking->schedule->field_id, // Ngambil ID lapangan dari relasi jadwal
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Nunggu lu (Admin) acc dulu!
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim dan sedang menunggu moderasi Admin.');
    }
}
