<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
              // Validate input
        $this->validator($request->all())->validate();

        // Create the user
        $user = $this->create($request->all());

        // Trigger the Registered event for email verification
        event(new Registered($user));

        // Send the email verification notification manually
        $user->notify(new \Illuminate\Auth\Notifications\VerifyEmail);

        // Redirect with success message
        return redirect()->route('login')->with('success', 'Registration successful! Please verify your email to proceed.');
    }

    /**
     * Validate the incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'USERNAME' => ['required', 'string', 'max:255', 'unique:users,USERNAME'],
            'FIRST_NAME' => ['required', 'string', 'max:255'],
            'LAST_NAME' => ['required', 'string', 'max:255'],
            'EMAIL' => ['required', 'string', 'email', 'max:255', 'unique:users,EMAIL'],
            'CATEGORY' => ['required', 'string'],
            'COURSE' => ['required', 'string', 'max:255'],
            'UNIVERSITY' => ['required', 'string', 'max:255'],
            'REASON' => ['required', 'string', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'USERNAME' => $data['USERNAME'],
            'FIRST_NAME' => $data['FIRST_NAME'],
            'LAST_NAME' => $data['LAST_NAME'],
            'EMAIL' => $data['EMAIL'],
            'CATEGORY' => $data['CATEGORY'],
            'COURSE' => $data['COURSE'],
            'UNIVERSITY' => $data['UNIVERSITY'],
            'REASON' => $data['REASON'],
            'PASSWORD_HASH' => Hash::make($data['password']),
        ]);
    }
}
