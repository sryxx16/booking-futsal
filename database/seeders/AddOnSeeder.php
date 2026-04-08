<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AddOn::create([
            'name' => 'Bola',
            'price' => 50000,
            'stock' => 10,
            'description' => 'Bola futsal standar internasional'
        ]);

        \App\Models\AddOn::create([
            'name' => 'Sepatu Futsal',
            'price' => 150000,
            'stock' => 15,
            'description' => 'Sepatu futsal premium akses kasual'
        ]);

        \App\Models\AddOn::create([
            'name' => 'Rompi/Bib',
            'price' => 25000,
            'stock' => 20,
            'description' => 'Rompi latihan untuk pembeda tim'
        ]);

        \App\Models\AddOn::create([
            'name' => 'Cone Training',
            'price' => 15000,
            'stock' => 30,
            'description' => 'Cone untuk marking lapangan'
        ]);

        \App\Models\AddOn::create([
            'name' => 'Tas Equipment',
            'price' => 100000,
            'stock' => 5,
            'description' => 'Tas untuk membawa peralatan'
        ]);
    }
}