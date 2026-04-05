<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'whatsapp_number',
        'address',
        'google_maps_link',
        'email',
        'description',
        'open_hours',
        'bank_name',     // PASTIKAN 3 BARIS INI ADA
        'bank_account',  // PASTIKAN 3 BARIS INI ADA
        'bank_owner',    // PASTIKAN 3 BARIS INI ADA
    ];
}
