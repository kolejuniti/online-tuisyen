<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'login_type' => 'required|in:user,student',
        ]);

        $credentials = $request->only('email', 'password');
        $guard = $request->input('login_type') === 'user' ? 'web' : 'student';
        $remember = $request->boolean('remember'); // Get the remember checkbox value

        // Check if email exists in the respective user table
        if ($guard === 'web') {
            $user = \App\Models\User::where('email', $credentials['email'])->first();
        } else {
            $user = \App\Models\Student::where('email', $credentials['email'])->first();
        }

        if (!$user) {
            // Email doesn't exist in the system
            $userType = $request->input('login_type') === 'user' ? 'teacher' : 'student';
            throw ValidationException::withMessages([
                'email' => ["This email address is not registered as a {$userType} account."],
            ]);
        }

        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($guard === 'web') {
                return redirect()->intended('/dashboard');
            } else {
                // For students, check if there's a custom intended URL
                $intendedUrl = session()->pull('url.intended'); // Get and remove from session
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }
                return redirect()->intended('/student/dashboard');
            }
        }

        // Email exists but password is wrong
        throw ValidationException::withMessages([
            'password' => ['The password you entered is incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
