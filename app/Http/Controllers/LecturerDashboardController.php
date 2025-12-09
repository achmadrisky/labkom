<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Course;
use Carbon\Carbon;

class LecturerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // 🔹 Ambil semua mata kuliah dosen
        $allCourses = \App\Models\Course::where('lecturer_id', $user->id)->get();

        // 🔹 Ambil hanya course yang punya jadwal hari ini (fixed & approved)
        $todayCourseIds = \App\Models\Booking::where('status', 'approved')
            ->where('type', 'fixed')
            ->where('date', $today)
            ->whereHas('course', fn($q) => $q->where('lecturer_id', $user->id))
            ->pluck('course_id')
            ->unique();

        $myCourses = $allCourses->whereIn('id', $todayCourseIds);

        // 🔹 Booking hari ini & besok (sudah ada dari sebelumnya)
        $todayBookings = Booking::with(['course', 'lab', 'requester'])
            ->where('status', 'approved')
            ->whereDate('date', $today)
            ->where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)
                ->orWhereHas('course', fn($c) => $c->where('lecturer_id', $user->id));
            })
            ->orderBy('start_time')
            ->get();

        $tomorrowBookings = Booking::with(['course', 'lab', 'requester'])
            ->where('status', 'approved')
            ->whereDate('date', $tomorrow)
            ->where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)
                ->orWhereHas('course', fn($c) => $c->where('lecturer_id', $user->id));
            })
            ->orderBy('start_time')
            ->get();

        // 🔹 Recent Bookings (5 terakhir)
        $recentBookings = Booking::with(['course', 'lab'])
            ->where('requester_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return view('lecturer.dashboard', compact(
            'user',
            'myCourses',
            'recentBookings',
            'today',
            'tomorrow',
            'todayBookings',
            'tomorrowBookings'
        ));
    }

}
