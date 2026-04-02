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
    ];
}
