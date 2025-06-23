<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\MembershipCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;



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
            'LAST_NAME' => 'nullable|string|max:255',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            // 'PASSWORD' => 'required|string|min:8',
            'GENDER' => 'required|in:Male,Female,Other',
            'PHONE_NUMBER' => 'required|string|max:20|unique:users,PHONE_NUMBER',
            'NATIONAL_ID_NUMBER' => 'required|string|max:50|unique:users,NATIONAL_ID_NUMBER',
            'DISABILITY_STATUS' => 'required|in:Yes,No',
            'DISABILITY_TYPE' => 'nullable|string|required_if:DISABILITY_STATUS,Yes',
            // 'CURRENTLY_IN_SCHOOL' => 'required|in:Yes,No',
            'HIGHEST_LEVEL_SCHOOL_ATTENDING' => 'nullable|required_if:CURRENTLY_IN_SCHOOL,Yes|in:TVET,College,University',
            'SCHOOL_NAME' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'PROGRAM_OF_STUDY' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'SCHOOL_REGISTRATION_NUMBER' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'HIGHEST_LEVEL_SCHOOL_ATTENDED' => 'nullable|in:TVET,College,University',
            'EDUCATION_LEVEL' => 'nullable|in:Undergraduate Degree,Post Graduate Diploma,Masters Degree,PhD',
            'PREVIOUS_SCHOOL_NAME' => 'nullable|string',
            'PREVIOUS_PROGRAM_OF_STUDY' => 'nullable|string',
            'REGISTRATION_FEE' => 'required|string|min:0',
            'PASSPORT_PHOTO' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // Newly added fields
            'TITTLE' => 'nullable|string|max:255',
            'POSTAL_ADDRESS' => 'nullable|string|max:255',
            'PHYSICAL_ADDRESS' => 'nullable|string|max:255',
            'COUNTY' => 'nullable|string|max:255',
            'LINKEDIN' => 'nullable|string|max:255',
            'PROFESSION' => 'nullable|string|max:255',
            'WORK_PLACE' => 'nullable|string|max:255',
            'JOB' => 'nullable|string|max:255',
            'COMMENT' => 'nullable|string',
            'DATE' => 'nullable|date',
            'type' => 'required|in:student,full,associate',
            'must_change_password' => 'required|boolean',

        ]);

        // Encrypt and store password
      $password = Str::random(10); // import Str at the top
      $validatedData['PASSWORD_HASH'] = Hash::make($password);

        // Set must_change_password flag
        $validatedData['must_change_password'] = 1;

// Generate unique membership number
do {
    $membershipNumber = implode('', collect(range(0, 9))->shuffle()->take(6)->all());
} while (User::where('MEMBERSHIP_NUMBER', $membershipNumber)->exists());

$validatedData['MEMBERSHIP_NUMBER'] = $membershipNumber;

// Handle photo upload
if ($request->hasFile('PASSPORT_PHOTO')) {
    $file = $request->file('PASSPORT_PHOTO');
    $photoFilename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('profile_photos'), $photoFilename);
    $validatedData['PASSPORT_PHOTO'] = 'profile_photos/' . $photoFilename;
}

// Generate the membership card PDF
$pdfPath = 'membership_cards/' . $membershipNumber . '.pdf';
$pdf = Pdf::loadView('pdf.membership_card', [
    'name' => $validatedData['FIRST_NAME'],
    'email' => $validatedData['EMAIL'],
    'membershipNumber' => $membershipNumber,
    'phone' => $validatedData['PHONE_NUMBER'],
    'photo' => $validatedData['PASSPORT_PHOTO'],
]);
$pdf->save(public_path($pdfPath));

// Create user
User::create($validatedData);

// Send email with PDF path
Mail::to($validatedData['EMAIL'])->send(
    new MembershipCredentialsMail(
        $validatedData['EMAIL'],
        $password,
        $validatedData['FIRST_NAME'],
        $membershipNumber,
        $validatedData['PHONE_NUMBER'],
        public_path($pdfPath) // ✅ Pass the actual PDF path
    )
);

        // Flash success and redirect
        session()->flash('success', 'You have successfully completed your registration. Your login credentials have been sent to the email address you provided. Kindly check your inbox or spam folder.');
        return redirect()->route('login');
    }
}
