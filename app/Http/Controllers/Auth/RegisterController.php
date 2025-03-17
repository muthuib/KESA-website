<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            $validatedData = $request->validate([
                'FIRST_NAME' => 'required|string|max:255',
                'LAST_NAME' => 'required|string|max:255',
                'EMAIL' => 'required|email|unique:users,EMAIL',
                'PASSWORD' => 'required|string|min:8',
                'GENDER' => 'required|in:Male,Female,Other',
                'PHONE_NUMBER' => 'required|string|max:20|unique:users,PHONE_NUMBER',
                'NATIONAL_ID_NUMBER' => 'required|string|max:50|unique:users,NATIONAL_ID_NUMBER',
                'DISABILITY_STATUS' => 'required|in:Yes,No',
                'DISABILITY_TYPE' => 'nullable|string|required_if:DISABILITY_STATUS,Yes',
                'CURRENTLY_IN_SCHOOL' => 'required|in:Yes,No',
                'HIGHEST_LEVEL_SCHOOL_ATTENDING' => 'nullable|required_if:CURRENTLY_IN_SCHOOL,Yes|in:TVET,College,University',
                'SCHOOL_NAME' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
                'PROGRAM_OF_STUDY' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
                'SCHOOL_REGISTRATION_NUMBER' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
                'HIGHEST_LEVEL_SCHOOL_ATTENDED' => 'nullable|in:TVET,College,University',
                'EDUCATION_LEVEL' => 'nullable|in:Undergraduate Degree,Post Graduate Diploma,Masters Degree,PhD',
                'PREVIOUS_SCHOOL_NAME' => 'nullable|string',
                'PREVIOUS_PROGRAM_OF_STUDY' => 'nullable|string',
                'REGISTRATION_FEE' => 'required|string|min:0',
                'PASSPORT_PHOTO' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image validation
            ]);

            // Encrypt password
            $validatedData['PASSWORD_HASH'] = Hash::make($validatedData['PASSWORD']);
            unset($validatedData['PASSWORD']); // Remove plain password

            // Handle file upload
            if ($request->hasFile('PASSPORT_PHOTO')) {
                $file = $request->file('PASSPORT_PHOTO');
                $filename = time() . '_' . $file->getClientOriginalName();
            
                // Move file directly to the public/profile_photos folder
                $file->move(public_path('profile_photos'), $filename);
            
                // Save only the relative path in the database
                $validatedData['PASSPORT_PHOTO'] = 'profile_photos/' . $filename;
            }
            
            // Generate unique membership number
            $validatedData['MEMBERSHIP_NUMBER'] = 'KESA' . str_pad(User::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create user
            User::create($validatedData);

            // Flash success message
            session()->flash('success', 'You have successfully registered. Please log in with your email and password.');

            // Redirect to login page
            return redirect()->route('login');
        }
}
