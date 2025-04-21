<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'EMAIL' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['EMAIL' => $credentials['EMAIL'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            // Check if the user needs to change their password
            if ($user->must_change_password) {
                // Redirect to the change password page if necessary
                return redirect()->route('password.change');
            }

            // Set a success message in the session
            session()->flash('success', 'You have logged in successfully. Welcome, ' . $user->FIRST_NAME . ' ' . $user->LAST_NAME . ' to KESA');

            // Redirect to the intended page (user dashboard)
            return redirect()->intended('/user-dashboard');
        }

        // If authentication fails, return back with error messages
        return back()->withErrors([
            'EMAIL' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
