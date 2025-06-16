<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::teachers()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ic' => 'required|string|max:20|unique:users,ic',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Store user request data: ' . json_encode($request->all()));

        DB::beginTransaction();

        try {

            $user = new User();
            $user->name = $request->name;
            $user->ic = $request->ic;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->user_type = 'Teacher';
            $user->password = Hash::make('12345678');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
                $user->image = $imagePath;
            }

            $user->save();
            
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // Log the error message
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'User creation failed. Please try again. Error: ' . $e->getMessage())->withInput();
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $updateValidated = $request->validate([
            'name' => 'required|string|max:255',
            'ic' => 'required|string|max:20|unique:users,ic,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Debug: Log all request data
            Log::info('Update user request data: ' . json_encode($request->all()));
            
            $updateData = array_filter($updateValidated, function($value) {
                return $value !== null;
            });

            // Debug: Log filtered data
            Log::info('Filtered update data: ' . json_encode($updateData));

            // Handle password if provided
            if (!empty($updateData['password'])) {
                $updateData['password'] = Hash::make($updateData['password']);
            } else {
                unset($updateData['password']);
            }

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                Log::info('Image file found in request');
                
                // Delete old image if exists
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                    Log::info('Deleted old image: ' . $user->image);
                }
                
                // Store new image
                $imagePath = $request->file('image')->store('users', 'public');
                $updateData['image'] = $imagePath;
                
                Log::info('New image path: ' . $imagePath);
            } else {
                Log::info('No image file in request');
            }

            Log::info('Final update data: ' . json_encode($updateData));
            
            // Debug: Log user data before update
            Log::info('User before update: ' . json_encode($user->toArray()));
            
            $result = $user->update($updateData);
            
            // Debug: Log result and user data after update
            Log::info('Update result: ' . ($result ? 'success' : 'failed'));
            Log::info('User after update: ' . json_encode($user->fresh()->toArray()));

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'User update failed. Please try again. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['status' => 'inactive']);
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }


    
}
