<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit()
    {
        $student = Auth::guard('student')->user();
        return view('student.settings', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::guard('student')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'phone_number' => 'nullable|string|max:20',
            'tingkatan' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'parent_guardian_name' => 'nullable|string|max:255',
            'parent_guardian_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update allowed fields
        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->phone_number = $validated['phone_number'] ?? null;
        $student->tingkatan = $validated['tingkatan'] ?? null;
        $student->date_of_birth = $validated['date_of_birth'] ?? null;
        $student->gender = $validated['gender'] ?? null;
        $student->parent_guardian_name = $validated['parent_guardian_name'] ?? null;
        $student->parent_guardian_phone = $validated['parent_guardian_phone'] ?? null;
        $student->address = $validated['address'] ?? null;

        if (!empty($validated['password'])) {
            $student->password = Hash::make($validated['password']);
        }

        $student->save();

        return redirect()->route('student.settings.edit')->with('success', 'Settings updated successfully.');
    }
}


