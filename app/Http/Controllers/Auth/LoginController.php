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
            return redirect()->intended('/app');
        }

        return back()->withErrors([
            'EMAIL' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}