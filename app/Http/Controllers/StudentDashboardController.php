<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Ambil mata kuliah yang diambil mahasiswa
        $myCourses = $user->courses ?? collect();

        // Ambil ID semua mata kuliah mahasiswa
        $courseIds = $myCourses->pluck('id')->toArray();

        // Tanggal hari ini & besok
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Ambil jadwal lab (hanya yang approved dan fixed dari admin)
        $todayBookings = Booking::with(['lab', 'course', 'requester'])
            ->where('status', 'approved')
            ->where('type', 'fixed') // ✅ hanya jadwal tetap yang dibuat admin
            ->whereIn('course_id', $courseIds)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $tomorrowBookings = Booking::with(['lab', 'course', 'requester'])
            ->where('status', 'approved')
            ->where('type', 'fixed')
            ->whereIn('course_id', $courseIds)
            ->whereDate('date', $tomorrow)
            ->orderBy('start_time')
            ->get();

        return view('student.dashboard', compact(
            'user',
            'myCourses',
            'today',
            'tomorrow',
            'todayBookings',
            'tomorrowBookings'
        ));
    }
}
