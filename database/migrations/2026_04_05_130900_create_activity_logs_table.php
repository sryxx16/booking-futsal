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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // user_id dibuat nullable jaga-jaga kalau sistem/cronjob yang eksekusi
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); // Contoh: 'Update Pembayaran'
            $table->text('description'); // Contoh: 'Admin menyetujui pembayaran Booking #123'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};