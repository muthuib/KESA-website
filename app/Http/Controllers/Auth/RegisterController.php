<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
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
        // Custom validation rules and messages
        $validator = Validator::make($request->all(), [
            'USERNAME' => 'required|string|max:255|unique:users,username',
            'EMAIL' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'USERNAME.unique' => 'Username already registered.',
            'EMAIL.unique' => 'Email already registered.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Send validation errors back to the view
                ->withInput(); // Retain the input fields
        }

        // Create the user
        $user = User::create([
            'USERNAME' => $request->USERNAME,
            'EMAIL' => $request->EMAIL,
            'PASSWORD_HASH' => Hash::make($request->password),
            'role' => 'STUDENT',
        ]);

        // Flash success message to the session
        session()->flash('success', 'You have successfully registered. Please login with your email and password.');

        // Redirect to the login page (or wherever you want the user to go)
        return redirect()->route('login');
    }
}
