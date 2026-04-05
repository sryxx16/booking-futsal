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
        Schema::create('add_on_booking', function (Blueprint $table) {
            $table->id();
            // Menyambungkan ke tabel bookings dan add_ons
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('add_on_id')->constrained()->onDelete('cascade');

            // Menyimpan jumlah barang yang disewa dan harga saat itu
            $table->integer('quantity');
            $table->integer('price'); // Disimpan agar jika harga master berubah, riwayat harga lama tidak ikut berubah

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_on_booking');
    }
};