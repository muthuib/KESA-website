<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //Displays login form to the user
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
            session()->flash('success', 'You have logged in successfully. Welcome, ' . Auth::user()->USERNAME . ' :' . Auth::user()->EMAIL . ' to Kenya Economics Students Association (KESA) Kenya. Explore our website to learn more!');

            return redirect()->intended('/app');
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