<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Tampilkan semua booking.
     */
    public function index(Request $request)
    {
        $type = $request->get('type'); // optional: ?type=fixed/manual
        $search = $request->get('search');
        $date = $request->get('date');
        $month = $request->get('month');

        $bookings = \App\Models\Booking::with(['lab', 'course', 'requester'])
            // 🔍 Filter berdasarkan tipe (fixed/manual)
            ->when($type, fn($q) => $q->where('type', $type))

            // 🔍 Filter berdasarkan tanggal
            ->when($date, fn($q) => $q->whereDate('date', $date))

            // 🔍 Filter berdasarkan bulan (format: YYYY-MM)
            ->when($month, function ($q, $month) {
                $year = substr($month, 0, 4);
                $monthNumber = substr($month, 5, 2);
                $q->whereYear('date', $year)->whereMonth('date', $monthNumber);
            })

            // 🔍 Search berdasarkan nama dosen, lab, atau matkul
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('requester', fn($r) => $r->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('lab', fn($r) => $r->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('course', fn($r) => $r->where('name', 'like', "%{$search}%"));
                });
            })

            // ->orderBy('date', 'desc')
            // ->orderBy('start_time')
            ->orderBy('id', 'desc') // urut berdasarkan id terbaru
            ->paginate(20)
            ->appends($request->query()); // biar pagination tetap menyimpan filter & search

        return view('admin.bookings.index', compact('bookings', 'type', 'search', 'date', 'month'));
    }


    /**
     * Form buat booking baru.
     */
    public function create()
    {
        $labs = Lab::all();
        $courses = Course::all();
        $lecturers = \App\Models\User::where('role', 'lecturer')->get(); // ✅ tambahkan pemilihan dosen

        return view('admin.bookings.create', compact('labs', 'courses', 'lecturers'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'course_id' => 'nullable|exists:courses,id',
            'requester_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $labId = $request->lab_id;
        $date = $request->date;
        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);

        // 🔍 Cek apakah jadwal tabrakan dengan jadwal lain di lab yang sama & tanggal yang sama
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


        // 🕒 Jika aman, buat jadwal utama
        $booking = Booking::create([
            'lab_id' => $request->lab_id,
            'course_id' => $request->course_id,
            'requester_id' => $request->requester_id,
            'approver_id' => auth()->id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'sks' => $request->sks ?? 2,
            'duration_minutes' => $start->diffInMinutes($end),
            'purpose' => $request->purpose,
            'status' => $request->status ?? 'approved',
            'type' => 'fixed',
        ]);

        // 🔁 Ulang mingguan jika dipilih
        if ($request->has('repeat_weekly')) {
            $startDate = \Carbon\Carbon::parse($request->date);
            for ($i = 1; $i <= 16; $i++) {
                $nextWeek = $startDate->copy()->addWeeks($i);

                // cek tabrakan juga sebelum generate tiap minggu
                $hasConflict = Booking::where('lab_id', $labId)
                    ->where('date', $nextWeek)
                    ->where('status', 'approved')
                    ->where(function ($query) use ($start, $end) {
                        $query->whereBetween('start_time', [$start, $end])
                            ->orWhereBetween('end_time', [$start, $end])
                            ->orWhere(function ($q) use ($start, $end) {
                                $q->where('start_time', '<', $start)
                                    ->where('end_time', '>', $end);
                            });
                    })
                    ->exists();

                if (!$hasConflict) {
                    Booking::create([
                        'lab_id' => $request->lab_id,
                        'course_id' => $request->course_id,
                        'requester_id' => $request->requester_id,
                        'approver_id' => auth()->id(),
                        'date' => $nextWeek,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'sks' => $request->sks ?? 2,
                        'duration_minutes' => $start->diffInMinutes($end),
                        'purpose' => $request->purpose,
                        'status' => 'approved',
                        'type' => 'fixed',
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dibuat!');
    }



    /**
     * Edit booking.
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $labs = Lab::all();
        $courses = Course::all();

        return view('admin.bookings.edit', compact('booking', 'labs', 'courses'));
    }

    /**
     * Update booking.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'course_id' => 'nullable|exists:courses,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'nullable|string|max:500',
            'status' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        $booking->update($request->all());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }
    
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        // Update status dan info persetujuan
        $booking->update([
            'status' => 'approved',
            'approver_id' => auth()->id(), // admin yang menyetujui
            'type' => 'fixed', // ubah dari manual → fixed agar tampil di schedule
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking has been approved successfully.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'rejected',
            'approver_id' => auth()->id(),
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking has been rejected.');
    }


    /**
     * Hapus booking.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
