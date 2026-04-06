<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua ulasan beserta data user dan lapangan, urutkan dari yang terbaru
        $reviews = Review::with(['user', 'field'])->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleStatus(Review $review)
    {
        // Ubah status (kalau false jadi true, kalau true jadi false)
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $statusMessage = $review->is_approved ? 'ditampilkan di Landing Page' : 'disembunyikan';

        // Catat ke Log Aktivitas (karena lu udah punya fitur CCTV ini!)
        \App\Models\ActivityLog::record(
            'Moderasi Ulasan',
            "Admin mengubah status ulasan dari {$review->user->name} menjadi {$statusMessage}"
        );

        return back()->with('success', "Ulasan berhasil {$statusMessage}!");
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus permanen!');
    }
}
