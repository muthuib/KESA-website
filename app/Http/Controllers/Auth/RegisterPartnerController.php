<?php

namespace App\Http\Controllers\Auth;

use App\Models\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;  // Add this line for email verification after successfull sign up

class RegisterPartnerController extends Controller
{
    
    //Displays registration form to the user
    public function showRegistrationForm()
    {
        return view('registration');
    }

    public function register(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'COMPANY_NAME' => 'required|string|max:255|unique:partners,company_name', // Ensure this matches your table's column name
            'REGISTRATION_NUMBER' => 'required|string|max:255|unique:partners,registration_number',
            'EMAIL' => 'required|string|email|max:255|unique:partners,email', // Ensure this matches your table's column name
            'PHONE_NUMBER' => 'required|integer|phone_number|max:9|unique:partners,phone_number',
            'PHYSICAL_ADDRESS' => 'required|string|physical_address|max:255',
            'PASSWORD' => 'required|string|min:8|confirmed', // Confirmed validation for password
            'REASON' => 'required|string|reason|max:255',
        ]);
        // Create the user
        $user = Partners::create([
            'COMPANY_NAME' => $request->COMPANY_NAME, // Use lowercase for consistency
            'REGISTRATION_NUMBER' => $request->REGISTRATION_NUMBERER,
            'EMAIL' => $request->EMAIL,       // Use lowercase for consistency
            'PHONE_NUMBER' => $request->PHONE_NUMBER,
            'PHYSICAL_ADDRESS' => $request->PHYSICAL_ADDRESS,
            'PASSWORD_HASH' => Hash::make($request->password), // Default password field
            'REASON' =>  $request-> REASON,
        ]);
        // Dispatch Registered event to send email verification
        event(new Registered($user));

        // Flash success message to the session
        session()->flash('success', 'You have successfully registered. Please login with your email and password.');

        // Redirect to the login page
        return redirect()->route('login');
    }

}