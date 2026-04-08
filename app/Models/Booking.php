<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'field_id', 'schedule_id', 'booking_name', 'phone_number', 'status', 'expired_at', 'promo_code_id', 'discount_amount'
    ];



    public function addOns()
    {
        return $this->belongsToMany(AddOn::class)
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'booking_schedule')->withTimestamps();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}