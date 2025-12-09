<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class EnrollmentController extends Controller
{
    // Menampilkan daftar mata kuliah yang bisa diambil
    public function index()
    {
        $courses = Course::with('students', 'lecturer')->get();
        $user = Auth::user();
        $myCourses = $user->courses->pluck('id')->toArray();

        return view('student.enrollments.index', compact('courses', 'myCourses'));
    }

    // Mendaftar ke mata kuliah
    public function enroll($courseId)
    {
        $user = Auth::user();

        if ($user->courses()->where('course_id', $courseId)->exists()) {
            return back()->with('info', 'Anda sudah mengambil mata kuliah ini.');
        }

        $user->courses()->attach($courseId);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    // Batalkan pendaftaran
    public function drop($courseId)
    {
        $user = Auth::user();
        $user->courses()->detach($courseId);

        return back()->with('success', 'Mata kuliah berhasil dibatalkan.');
    }
}
