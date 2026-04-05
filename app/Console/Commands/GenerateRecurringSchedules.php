<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Membership;
use App\Models\Schedule;
use App\Models\Booking;
use Carbon\Carbon;

class GenerateRecurringSchedules extends Command
{
    // Nama command untuk dijalankan di terminal
    protected $signature = 'schedules:generate-recurring';

    protected $description = 'Otomatis membuat jadwal dan booking untuk Member Aktif minggu depan';

    public function handle()
    {
        // 1. Ambil semua member yang masih aktif dan masa kontraknya belum habis
        $memberships = Membership::with('user')
            ->where('is_active', true)
            ->where('end_date', '>=', now()->toDateString())
            ->get();

        // Mapping nama hari bahasa Indonesia ke konstan Carbon
        $daysMap = [
            'Senin' => Carbon::MONDAY, 'Selasa' => Carbon::TUESDAY,
            'Rabu' => Carbon::WEDNESDAY, 'Kamis' => Carbon::THURSDAY,
            'Jumat' => Carbon::FRIDAY, 'Sabtu' => Carbon::SATURDAY,
            'Minggu' => Carbon::SUNDAY,
        ];

        $generatedCount = 0;

        foreach ($memberships as $member) {
            $targetDay = $daysMap[$member->day] ?? null;
            if (!$targetDay) continue;

            // 2. Cari tanggal untuk hari tersebut di minggu depan (7 hari ke depan)
            $targetDate = now()->next($targetDay)->format('Y-m-d');

            // 3. Pastikan tanggal target tersebut masih dalam masa kontrak member
            if ($targetDate < $member->start_date || $targetDate > $member->end_date) {
                continue;
            }

            // 4. Cek apakah di tanggal dan jam itu jadwalnya udah terbuat atau belum
            $existingSchedule = Schedule::where('field_id', $member->field_id)
                ->where('date', $targetDate)
                ->where('start_time', $member->start_time)
                ->first();

            // 5. Kalau belum ada, kita blok lapangannya!
            if (!$existingSchedule) {
                // Buat Jadwal
                $schedule = Schedule::create([
                    'field_id' => $member->field_id,
                    'day' => $member->day,         // <--- TAMBAHKAN BARIS INI BANG
                    'date' => $targetDate,
                    'start_time' => $member->start_time,
                    'end_time' => $member->end_time,
                    'is_recurring' => true,
                ]);

                // Buat Booking atas nama tim member (status pending, nanti admin/user tinggal bayar per sesi)
                Booking::create([
                    'user_id' => $member->user_id,
                    'schedule_id' => $schedule->id,
                    'field_id' => $member->field_id,    // <--- TAMBAHIN BARIS INI
                    'booking_name' => $member->team_name . ' (Member)',
                    'phone_number' => $member->user->phone_number ?? '-',
                    'status' => 'pending',
                ]);

                $this->info("Berhasil memblokir jadwal untuk: {$member->team_name} di tanggal {$targetDate}");
                $generatedCount++;
            }
        }

        $this->info("Selesai! {$generatedCount} jadwal member berhasil digenerate.");
    }
}
