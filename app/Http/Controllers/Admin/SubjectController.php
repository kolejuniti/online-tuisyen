<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subjects', 'public');
            $data['image'] = $imagePath;
        }

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subject = Subject::findOrFail($id);
        
        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subject->image && Storage::disk('public')->exists($subject->image)) {
                Storage::disk('public')->delete($subject->image);
            }
            
            $imagePath = $request->file('image')->store('subjects', 'public');
            $data['image'] = $imagePath;
        }

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        
        // Delete image if exists
        if ($subject->image && Storage::disk('public')->exists($subject->image)) {
            Storage::disk('public')->delete($subject->image);
        }
        
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
