<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'field_id', 'team_name', 'day',
        'start_time', 'end_time', 'special_price',
        'start_date', 'end_date', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
