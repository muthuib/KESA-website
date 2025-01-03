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

        if (Auth::attempt(['EMAIL' => $credentials['EMAIL'], 'password' => $credentials['password']])) {
            // Set a success message in session
            // Flash success message with user's first name and last name
            session()->flash('success', 'You have logged in successfully. Welcome, ' . Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME . ' to KESA');

            return redirect()->intended('/user-dashboard');
        }

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