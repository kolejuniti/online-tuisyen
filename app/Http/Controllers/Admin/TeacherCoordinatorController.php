<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherCoordinator;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherCoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coordinators = TeacherCoordinator::with('school')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.teacher-coordinators.index', compact('coordinators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get schools that don't have a coordinator yet
        $schools = School::whereDoesntHave('teacherCoordinator')
            ->orderBy('name')
            ->get();

        return view('admin.teacher-coordinators.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
                Rule::unique('teacher_coordinators', 'school_id')
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ], [
            'school_id.unique' => 'This school already has a teacher coordinator assigned.',
            'school_id.required' => 'Please select a school.',
            'school_id.exists' => 'Selected school does not exist.',
            'name.required' => 'Teacher coordinator name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $coordinator = TeacherCoordinator::create([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('admin.teacher-coordinators.index')
            ->with('success', "Teacher coordinator created successfully! Secret code: {$coordinator->secret_code}");
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherCoordinator $teacherCoordinator)
    {
        $teacherCoordinator->load('school');
        return view('admin.teacher-coordinators.show', compact('teacherCoordinator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherCoordinator $teacherCoordinator)
    {
        // Get schools that don't have a coordinator yet, plus the current school
        $schools = School::where(function ($query) use ($teacherCoordinator) {
            $query->whereDoesntHave('teacherCoordinator')
                  ->orWhere('id', $teacherCoordinator->school_id);
        })->orderBy('name')->get();

        return view('admin.teacher-coordinators.edit', compact('teacherCoordinator', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherCoordinator $teacherCoordinator)
    {
        $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
                Rule::unique('teacher_coordinators', 'school_id')->ignore($teacherCoordinator->id)
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ], [
            'school_id.unique' => 'This school already has a teacher coordinator assigned.',
            'school_id.required' => 'Please select a school.',
            'school_id.exists' => 'Selected school does not exist.',
            'name.required' => 'Teacher coordinator name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $teacherCoordinator->update([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('admin.teacher-coordinators.index')
            ->with('success', 'Teacher coordinator updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherCoordinator $teacherCoordinator)
    {
        $schoolName = $teacherCoordinator->school->name;
        $teacherCoordinator->delete();

        return redirect()
            ->route('admin.teacher-coordinators.index')
            ->with('success', "Teacher coordinator for {$schoolName} has been deleted successfully!");
    }

    /**
     * Generate a new secret code for the coordinator.
     */
    public function generateNewCode(TeacherCoordinator $teacherCoordinator)
    {
        $newCode = TeacherCoordinator::generateSecretCode();
        $teacherCoordinator->update(['secret_code' => $newCode]);

        return redirect()
            ->back()
            ->with('success', "New secret code generated: {$newCode}");
    }
}
