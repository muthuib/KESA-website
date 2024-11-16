<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        // Validate the request inputs
        $request->validate([
            'USERNAME' => 'required|string|max:255|unique:users,username', // Ensure this matches your table's column name
            'EMAIL' => 'required|string|email|max:255|unique:users,email', // Ensure this matches your table's column name
            'password' => 'required|string|min:8|confirmed', // Confirmed validation for password
        ]);

        // Create the user
        $user = User::create([
            'USERNAME' => $request->USERNAME, // Use lowercase for consistency
            'EMAIL' => $request->EMAIL,       // Use lowercase for consistency
            'PASSWORD_HASH' => Hash::make($request->password), // Default password field
            'role' => 'STUDENT', // Default role (can be customized)
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the intended page after registration, e.g. home or dashboard
        return redirect()->route('home'); // Make sure this route exists
    }
}
