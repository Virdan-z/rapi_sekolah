<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'title',
        'event_date',
        'end_date', // <-- Ditambahkan di sini
        'start_time',
        'end_time',
        'status',
        'move_reason',
        'pic_note',
        'description',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}