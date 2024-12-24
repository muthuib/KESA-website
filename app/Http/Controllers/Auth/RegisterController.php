<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

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
            'USERNAME' => 'required|string|max:255|unique:users,USERNAME',
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'required|string|max:255',
            'EMAIL' => 'required|string|email|max:255|unique:users,email',
            'CATEGORY' => 'required|string|max:255',
            'COURSE' => 'required|string|max:255',
            'UNIVERSITY' => 'required|string|max:255',
            'REASON' => 'nullable|string|max:1000', // Optional field
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'USERNAME' => $request->USERNAME,
            'FIRST_NAME' => $request->FIRST_NAME,
            'LAST_NAME' => $request->LAST_NAME,
            'EMAIL' => $request->EMAIL,
            'CATEGORY' => $request->CATEGORY,
            'COURSE' => $request->COURSE,
            'UNIVERSITY' => $request->UNIVERSITY,
            'REASON' => $request->REASON,
            'PASSWORD_HASH' => Hash::make($request->password),
        ]);

        // Dispatch Registered event (optional)
        event(new Registered($user));

        // Flash success message to the session
        session()->flash('success', 'You have successfully registered. Please login with your username and password.');

        // Redirect to the login page
        return redirect()->route('login');
    }
}
