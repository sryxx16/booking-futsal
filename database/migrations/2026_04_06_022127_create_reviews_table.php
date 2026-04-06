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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Siapa yang ngereview
            $table->foreignId('field_id')->constrained()->cascadeOnDelete(); // Lapangan mana yang direview
            $table->foreignId('booking_id')->nullable()->constrained()->cascadeOnDelete(); // Bukti dia beneran booking
            $table->integer('rating'); // Bintang 1-5
            $table->text('comment'); // Isi ulasan
            $table->boolean('is_approved')->default(false); // Default false, nunggu di-acc admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};