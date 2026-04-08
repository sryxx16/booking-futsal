<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PromoCode::create([
            'code' => 'FUTSALL',
            'type' => 'fixed',
            'value' => 50000,
            'quota' => 100,
            'used_count' => 0,
            'valid_until' => now()->addMonths(3),
            'is_active' => true
        ]);

        \App\Models\PromoCode::create([
            'code' => 'WEEKEND50',
            'type' => 'percentage',
            'value' => 50,
            'quota' => 50,
            'used_count' => 0,
            'valid_until' => now()->addMonths(2),
            'is_active' => true
        ]);

        \App\Models\PromoCode::create([
            'code' => 'MEMBER2024',
            'type' => 'fixed',
            'value' => 100000,
            'quota' => 200,
            'used_count' => 0,
            'valid_until' => now()->addMonths(6),
            'is_active' => true
        ]);
    }
}
