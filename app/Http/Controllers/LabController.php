<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Display a listing of the labs.
     */
    public function index()
    {
        $labs = Lab::orderBy('name')->get();
        return view('admin.labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new lab.
     */
    public function create()
    {
        return view('admin.labs.create');
    }

    /**
     * Store a newly created lab in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:labs,name',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
        ]);

        Lab::create($validated);

        return redirect()->route('admin.labs.index')->with('success', 'Lab created successfully.');
    }

    /**
     * Show the form for editing the specified lab.
     */
    public function edit(Lab $lab)
    {
        return view('admin.labs.edit', compact('lab'));
    }

    /**
     * Update the specified lab in storage.
     */
    public function update(Request $request, Lab $lab)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:labs,name,' . $lab->id,
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
        ]);

        $lab->update($validated);

        return redirect()->route('admin.labs.index')->with('success', 'Lab updated successfully.');
    }

    /**
     * Remove the specified lab from storage.
     */
    public function destroy(Lab $lab)
    {
        $lab->delete();

        return redirect()->route('admin.labs.index')->with('success', 'Lab deleted successfully.');
    }
}
