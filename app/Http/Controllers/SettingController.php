<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data setting pertama (karena kita cuma butuh 1 baris konfigurasi)
        // Kalau belum ada di database, kita bikin instance kosong biar view-nya nggak error
        $setting = Setting::first() ?? new Setting();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // Validasi inputan
        $validated = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'google_maps_link' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'open_hours' => 'nullable|string|max:255',
        ]);

        // Cek apakah data setting sudah ada? Kalau ada di-update, kalau belum di-create
        $setting = Setting::first();
        if ($setting) {
            $setting->update($validated);
        } else {
            Setting::create($validated);
        }

        return redirect()->back()->with('success', 'Pengaturan Web berhasil diperbarui!');
    }
}
