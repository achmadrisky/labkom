<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));   
    }

    public function create()
    {

        $lecturers = \App\Models\User::where('role', 'lecturer')->get();
        return view('admin.courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:courses,code',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:2|max:4',
            'lecturer_id' => 'nullable|exists:users,id',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(Course $course)
    {
        $lecturers = \App\Models\User::where('role', 'lecturer')->get();
        return view('admin.courses.edit', compact('course', 'lecturers'));
    }

    public function update(Request $request, Course $course)
{
    $request->validate([
        'code' => 'required|string|max:10|unique:courses,code,' . $course->id,
        'name' => 'required|string|max:255',
        'sks' => 'required|integer|min:2|max:4',
        'lecturer_id' => 'nullable|exists:users,id',
    ]);

    $course->update($request->all());

    return redirect()->route('admin.courses.index')
        ->with('success', 'Mata kuliah berhasil diperbarui.');
}

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
