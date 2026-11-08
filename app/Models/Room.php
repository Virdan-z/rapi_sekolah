<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'location',
        'capacity',
        'description',
    ];

    // Diubah menjadi pics() agar sesuai dengan RoomController baris 20
    public function pics()
    {
        return $this->belongsToMany(User::class, 'room_pic')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}