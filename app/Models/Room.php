<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Room extends Model
{
    protected $fillable = [
        'pic_id',
        'name',
        'location',
        'capacity',
        'description',
    ];

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
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