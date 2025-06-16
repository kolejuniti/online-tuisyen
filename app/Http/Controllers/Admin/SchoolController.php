<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the schools.
     */
    public function index()
    {
        $schools = School::all();
        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        School::create($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'School created successfully.');
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $school->update($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'School deleted successfully.');
    }
} 