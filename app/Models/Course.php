<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'sks', 'lecturer_id'];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withTimestamps();
    }


}

