<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lab;
use App\Models\Course;
use App\Models\Booking;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
        {
            // Hitung total data
            $totalUsers    = User::count();
            $totalLabs     = Lab::count();
            $totalCourses  = Course::count();
            $totalBookings = Booking::count();

            // Booking terbaru
            $recentBookings = Booking::with(['lab','course','requester'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            // Statistik tambahan (opsional, bisa dipakai nanti)
            $todayBookings = Booking::whereDate('date', Carbon::today())->count();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalLabs',
                'totalCourses',
                'totalBookings',
                'recentBookings',
                'todayBookings'
            ));
        }
}
