<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $fields = Field::count();
        $bookings = Booking::count(); // Menghitung jumlah total booking
        $users = User::where('role', 'user')->count();
        $schedules = Schedule::count();
        $totalPayments = Payment::sum('amount'); // Total seluruh pembayaran
        $payments = Payment::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status'); // Statistik pembayaran berdasarkan status

        // --- TAMBAHAN BARU: Data Pendapatan Bulanan (Tahun Semasa) ---
        $currentYear = date('Y');
        $monthlyRevenueRaw = Payment::where('status', 'paid')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Susun data untuk memastikan kesemua 12 bulan ada (walaupun nilainya 0)
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenueRaw[$i] ?? 0;
        }

        return view('admin.dashboard', compact('fields', 'bookings', 'users', 'schedules', 'totalPayments', 'payments', 'revenueData'));
    }

    public function exportPdf()
    {
        // Ambil data pembayaran yang sudah 'paid' beserta data booking-nya
        $payments = Payment::where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = $payments->sum('amount');

        // Load halaman view khusus PDF
        $pdf = Pdf::loadView('admin.reports.pdf', compact('payments', 'totalPendapatan'));

        // Atur ukuran kertas ke A4 (landscape atau portrait)
        $pdf->setPaper('A4', 'landscape');

        // Download file-nya
        return $pdf->download('laporan-pendapatan-futsal-' . date('Y-m-d') . '.pdf');
    }
}