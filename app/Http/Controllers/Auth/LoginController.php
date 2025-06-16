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

        if (Auth::guard($guard)->attempt($credentials)) {
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

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
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
