<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil data log, urutkan dari yang terbaru, lalu pagination per 50 baris
        // Biar web lu nggak lemot kalau log-nya udah ribuan
        $logs = ActivityLog::with('user')->latest()->paginate(50);

        return view('admin.activity-logs.index', compact('logs'));
    }
}
