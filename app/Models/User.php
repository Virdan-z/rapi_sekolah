<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi user dengan banyak ruangan.
     * Satu PIC dapat bertanggung jawab atas beberapa ruangan.
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_pic')
            ->withTimestamps();
    }

    /**
     * Relasi user dengan event.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relasi user dengan pengaduan.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}