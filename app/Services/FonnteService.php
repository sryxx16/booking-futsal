<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    public static function sendMessage($target, $message)
    {
        // Pastikan nomor diawali dengan 08 atau 62
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'countryCode' => '62', // Otomatis menyesuaikan ke nomor Indonesia
        ]);

        return $response->json();
    }
}
