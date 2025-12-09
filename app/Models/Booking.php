<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_id',
        'course_id',
        'requester_id',
        'approver_id',
        'date',
        'start_time',
        'end_time',
        'sks',
        'duration_minutes',
        'purpose',
        'status',
        'type', // ✅ jadwal tetap (fixed) atau booking biasa
    ];

    /**
     * Relasi ke model Lab
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * Relasi ke model Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi ke user yang melakukan booking (requester)
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Relasi ke user yang menyetujui booking (approver)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Scope untuk hanya mengambil booking yang disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk hanya mengambil booking bertipe tetap (fixed)
     */
    public function scopeFixed($query)
    {
        return $query->where('type', 'fixed');
    }
}
