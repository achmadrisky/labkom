<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pastikan hanya lecturer yang bisa akses
        if ($user->role !== 'lecturer') {
            abort(403, 'Unauthorized access.');
        }

        // Ambil parameter filter dari request
        $search = $request->get('search'); // opsional: cari nama matkul / lab
        $date = $request->get('date');     // format: YYYY-MM-DD
        $month = $request->get('month');   // format: YYYY-MM

        // Base query - HANYA bookings milik lecturer ini
        $bookings = Booking::with(['lab', 'course', 'requester'])
            ->where('requester_id', $user->id) // Hanya booking milik sendiri
            // 🔍 Filter berdasarkan tanggal tertentu
            ->when($date, fn($q) => $q->whereDate('date', $date))
            // 🔍 Filter berdasarkan bulan (YYYY-MM)
            ->when($month, function ($q, $month) {
                $year = substr($month, 0, 4);
                $monthNum = substr($month, 5, 2);
                $q->whereYear('date', $year)->whereMonth('date', $monthNum);
            })
            // 🔍 Search umum berdasarkan nama lab / course
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('lab', fn($lab) => $lab->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('course', fn($course) => $course->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate(10)
            ->appends($request->query());

        return view('lecturer.bookings.index', compact('bookings', 'search', 'date', 'month'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'lecturer') {
            abort(403, 'Unauthorized access.');
        }

        $labs = Lab::all();
        $courses = Course::where('lecturer_id', $user->id)->get(); // Hanya courses yang diajarkan oleh lecturer ini
        
        return view('lecturer.bookings.create', compact('labs', 'courses'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'lecturer') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'course_id' => 'nullable|exists:courses,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'sks' => 'required|integer|min:1|max:4',
            'duration_minutes' => 'required|integer|min:30',
            'purpose' => 'nullable|string|max:500',
        ]);

        // Cek apakah course milik lecturer ini
        if ($request->course_id) {
            $course = Course::find($request->course_id);
            if ($course->lecturer_id !== $user->id) {
                abort(403, 'You can only book for your own courses.');
            }
        }

        // Cek jadwal bentrok
        $overlap = Booking::where('lab_id', $request->lab_id)
            ->whereDate('date', $request->date)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                          ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withErrors(['schedule' => 'Jadwal bentrok! Laboratorium sudah digunakan pada waktu tersebut.'])
                ->withInput();
        }

        Booking::create([
            'lab_id' => $request->lab_id,
            'course_id' => $request->course_id,
            'requester_id' => $user->id,
            'approver_id' => null, // Akan diisi oleh admin saat approve
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'sks' => $request->sks,
            'duration_minutes' => $request->duration_minutes,
            'purpose' => $request->purpose,
            'status' => 'pending', // Lecturer selalu pending, admin yang approve
            'type' => 'manual',
        ]);

        return redirect()->route('lecturer.bookings.index')
            ->with('success', 'Booking created successfully! Waiting for admin approval.');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $user = Auth::user();
        
        // Pastikan hanya pemilik booking yang bisa melihat
        if ($booking->requester_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('lecturer.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        $user = Auth::user();

        // Pastikan hanya pemilik booking yang bisa edit
        if ($booking->requester_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Hanya booking dengan status pending yang bisa diedit
        if ($booking->status !== 'pending') {
            return redirect()->route('lecturer.bookings.index')
                ->with('error', 'Only pending bookings can be edited.');
        }

        $labs = Lab::all();
        $courses = Course::where('lecturer_id', $user->id)->get();
        
        return view('lecturer.bookings.edit', compact('booking', 'labs', 'courses'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // Pastikan hanya pemilik booking yang bisa update
        if ($booking->requester_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Hanya booking pending yang bisa diupdate
        if ($booking->status !== 'pending') {
            return redirect()->route('lecturer.bookings.index')
                ->with('error', 'Only pending bookings can be updated.');
        }

        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'course_id' => 'nullable|exists:courses,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'sks' => 'required|integer|min:1|max:4',
            'duration_minutes' => 'required|integer|min:30',
            'purpose' => 'nullable|string|max:500',
        ]);

        // Cek jadwal bentrok (kecuali dengan booking ini sendiri)
        $overlap = Booking::where('lab_id', $request->lab_id)
            ->where('id', '!=', $booking->id)
            ->whereDate('date', $request->date)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                          ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withErrors(['schedule' => 'Jadwal bentrok! Laboratorium sudah digunakan pada waktu tersebut.'])
                ->withInput();
        }

        $booking->update([
            'lab_id' => $request->lab_id,
            'course_id' => $request->course_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'sks' => $request->sks,
            'duration_minutes' => $request->duration_minutes,
            'purpose' => $request->purpose,
        ]);

        return redirect()->route('lecturer.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified booking
     */
    public function destroy(Booking $booking)
    {
        $user = Auth::user();

        // Pastikan hanya pemilik booking yang bisa hapus
        if ($booking->requester_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Hanya booking pending yang bisa dihapus
        if ($booking->status !== 'pending') {
            return redirect()->route('lecturer.bookings.index')
                ->with('error', 'Only pending bookings can be deleted.');
        }

        $booking->delete();

        return redirect()->route('lecturer.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}