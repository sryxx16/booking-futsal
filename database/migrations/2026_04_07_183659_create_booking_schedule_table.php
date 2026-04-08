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
        Schema::create('booking_schedule', function (Blueprint $table) {
            $table->id();
            // ID Booking (Invoice-nya)
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            // ID Schedule (Jam-jam yang dipilih)
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_schedule');
    }
};