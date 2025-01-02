<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request inputs
        $validatedData = $request->validate([
            'USERNAME' => 'required|string|max:255|unique:users,USERNAME',
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'required|string|max:255',
            'EMAIL' => 'required|string|email|max:255|unique:users,EMAIL',
            'CATEGORY' => 'required|string|max:255',
            'COURSE' => 'required|string|max:255',
            'UNIVERSITY' => 'required|string|max:255',
            'REASON' => 'nullable|string|max:1000', // Optional field
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'USERNAME' => $validatedData['USERNAME'],
            'FIRST_NAME' => $validatedData['FIRST_NAME'],
            'LAST_NAME' => $validatedData['LAST_NAME'],
            'EMAIL' => $validatedData['EMAIL'],
            'CATEGORY' => $validatedData['CATEGORY'],
            'COURSE' => $validatedData['COURSE'],
            'UNIVERSITY' => $validatedData['UNIVERSITY'],
            'REASON' => $validatedData['REASON'],
            'PASSWORD_HASH' => Hash::make($validatedData['password']),
        ]);

        // Trigger the email verification event
        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registration successful! Please verify your email to proceed.');
    }
}
