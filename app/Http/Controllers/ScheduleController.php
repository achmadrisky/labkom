<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $week = $request->get('week');
        $today = $week ? Carbon::parse($week) : Carbon::today();

        // Range minggu aktif
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        // Ambil filter
        $selectedLecturer = $request->get('lecturer');
        $selectedLab = $request->get('lab');

        // Query dasar
        $query = Booking::with(['lab', 'course', 'requester'])
            ->where('status', 'approved')
            ->where('type', 'fixed')
            ->whereBetween('date', [$startOfWeek, $endOfWeek]);

        // Eksekusi query
        $weeklyBookings = $query->orderBy('date')->orderBy('start_time')->get();

        // Group berdasarkan hari
        $bookingsByDay = $weeklyBookings->groupBy(function ($booking) {
            return Carbon::parse($booking->date)->format('l');
        });

        // Data untuk dropdown filter
        $lecturers = \App\Models\User::where('role', 'lecturer')->get();
        $labs = \App\Models\Lab::all();

        return view('schedule.index', compact(
            'bookingsByDay', 'startOfWeek', 'endOfWeek',
            'lecturers', 'labs', 'selectedLecturer', 'selectedLab'
        ));


        
    }


}
