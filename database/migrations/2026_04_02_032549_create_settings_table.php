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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('app_name')->default('Futsal Booking');
        $table->string('whatsapp_number')->nullable();
        $table->text('address')->nullable();
        $table->text('google_maps_link')->nullable();
        $table->string('email')->nullable();
        $table->text('description')->nullable();
        $table->string('open_hours')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};