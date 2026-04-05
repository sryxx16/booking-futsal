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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode promo (ex: FUTSALWEEKEND)
            $table->enum('type', ['percentage', 'fixed']); // Tipe: persentase (10%) atau nominal (Rp 20.000)
            $table->integer('value'); // Nilai diskonnya
            $table->integer('quota')->default(0); // Batas maksimal penggunaan (kuota)
            $table->integer('used_count')->default(0); // Jumlah promo yang sudah terpakai
            $table->date('valid_until'); // Tanggal kedaluwarsa promo
            $table->boolean('is_active')->default(true); // Status promo (Bisa dimatikan manual)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
