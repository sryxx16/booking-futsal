<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            [
                'name' => 'Lapangan A',
                'price_per_hour' => 100000,
                'description' => 'Lapangan utama untuk pertandingan',
                'location' => 'jakarta', // Atur ke null jika kolom dapat NULL
                'photo'=>'ajaja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
