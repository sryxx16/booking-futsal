<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateRecurringSchedules extends Command
{
    protected $signature = 'schedules:generate-recurring';
    protected $description = 'Otomatis menduplikat jadwal rutin ke hari berikutnya dengan aman';

    public function handle()
    {
        $generatedCount = 0;

        // 1. Ambil template waktu yang unik biar ngga dobel-dobel
        // Kita cuma butuh field_id, start_time, dan end_time
        $templates = Schedule::where('is_recurring', true)
            ->select('field_id', 'start_time', 'end_time')
            ->distinct()
            ->get();

        // 2. Kita loop dari HARI INI ($i = 0) sampai 7 hari ke depan
        for ($i = 0; $i <= 7; $i++) {
            $targetDate = now()->addDays($i)->format('Y-m-d');
            $targetDayName = now()->addDays($i)->translatedFormat('l');

            foreach ($templates as $template) {
                // Gunakan whereTime biar format '15:00' dan '15:00:00' dianggap sama!
                $exists = Schedule::where('field_id', $template->field_id)
                    ->where('date', $targetDate)
                    ->whereTime('start_time', $template->start_time)
                    ->exists();

                if (!$exists) {
                    Schedule::create([
                        'field_id' => $template->field_id,
                        'day' => $targetDayName,
                        'date' => $targetDate,
                        'start_time' => $template->start_time,
                        'end_time' => $template->end_time,
                        'is_recurring' => true,
                        'is_available' => true,
                    ]);
                    $generatedCount++;
                }
            }
        }

        $this->info("Selesai! {$generatedCount} slot jadwal baru berhasil dicetak dengan rapi tanpa duplikat.");
    }
}
