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

    public function financialReport(\Illuminate\Http\Request $request)
    {
        // Mulai query untuk mengambil payment yang sudah lunas beserta relasi booking dan usernya
        $query = \App\Models\Payment::with(['booking.user', 'booking.field'])->where('status', 'paid');

        // Jika ada filter tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Jika ada filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Eksekusi query, urutkan dari yang terbaru
        $payments = $query->orderBy('created_at', 'desc')->get();

        // Hitung total pendapatan dan total transaksi dari data yang difilter
        $totalIncome = $payments->sum('amount');
        $totalTransactions = $payments->count();

        return view('admin.reports.financial', compact('payments', 'totalIncome', 'totalTransactions'));
    }
}
