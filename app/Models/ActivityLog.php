<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'description'];

    // Relasi ke siapa yang ngelakuin aksi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi canggih biar lu gampang nyatet log di Controller manapun
    public static function record($action, $description)
    {
        self::create([
            'user_id' => Auth::id(), // Otomatis ngambil ID admin yang lagi login
            'action' => $action,
            'description' => $description,
        ]);
    }
}