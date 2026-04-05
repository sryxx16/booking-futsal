<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Member ini nyambung ke akun siapa
            $table->foreignId('field_id')->constrained()->onDelete('cascade'); // Main di lapangan mana

            $table->string('team_name'); // Nama tim futsalnya
            $table->string('day'); // Hari main (Senin, Selasa, dst)
            $table->time('start_time'); // Jam mulai rutin
            $table->time('end_time'); // Jam selesai rutin

            $table->decimal('special_price', 10, 2); // Harga khusus per pertemuan buat member

            $table->date('start_date'); // Masa kontrak mulai
            $table->date('end_date'); // Masa kontrak habis
            $table->boolean('is_active')->default(true); // Status aktif/enggak

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};