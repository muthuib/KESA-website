<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'USERNAME' => 'required|string|max:255|unique:users',
            'EMAIL' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'USERNAME' => $request->USERNAME,
            'EMAIL' => $request->EMAIL,
            'PASSWORD_HASH' => Hash::make($request->password),
            'ROLE' => 'STUDENT', // Default role or change as needed
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}