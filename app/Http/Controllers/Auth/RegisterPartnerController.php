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

    public function registration(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'COMPANY_NAME' => 'required|string|max:255|unique:partners,company_name',
            'REGISTRATION_NUMBER' => 'required|string|max:255|unique:partners,registration_number',
            'EMAIL' => 'required|string|email|max:255|unique:partners,email',
            'PHONE_NUMBER' => 'required|digits:10|unique:partners,phone_number',
            'PHYSICAL_ADDRESS' => 'required|string',
            'COMPANY_TYPE' => 'nullable|string', // Allow NULL or provide a default value
            'REASON' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create the record
        $partner = Partners::create([
            'COMPANY_NAME' => $request->COMPANY_NAME,
            'REGISTRATION_NUMBER' => $request->REGISTRATION_NUMBER,
            'EMAIL' => $request->EMAIL,
            'PHONE_NUMBER' => $request->PHONE_NUMBER,
            'PHYSICAL_ADDRESS' => $request->PHYSICAL_ADDRESS,
            'COMPANY_TYPE' => $request->COMPANY_TYPE ?? '', // Use empty string if NULL
            'REASON' => $request->REASON,
            'PASSWORD' => Hash::make($request->password),
        ]);
    
        // Flash success message
        session()->flash('success', 'You have successfully registered your company. Please log in with your company email and password.');
    
        // Redirect to login page
        return redirect()->route('login');
    }
    
}