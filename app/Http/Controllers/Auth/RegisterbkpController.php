<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\MembershipCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'nullable|string|max:255',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            'GENDER' => 'required|in:Male,Female,Other',
            'PHONE_NUMBER' => 'required|string|max:20|unique:users,PHONE_NUMBER',
            'NATIONAL_ID_NUMBER' => 'required|string|max:50|unique:users,NATIONAL_ID_NUMBER',
            'DISABILITY_STATUS' => 'required|in:Yes,No',
            'DISABILITY_TYPE' => 'nullable|string|required_if:DISABILITY_STATUS,Yes',
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

        // Generate a random password and hash it
        $password = Str::random(10);
        $validatedData['PASSWORD_HASH'] = Hash::make($password);

        // Force user to change password on first login
        $validatedData['must_change_password'] = $request->boolean('must_change_password', true);

        // Generate unique membership number
       // Generate formatted membership number: YY + IDlast2 + 4-digit reg
        $year = now()->format('y'); // e.g., '25' for 2025
        $idSuffix = substr($validatedData['NATIONAL_ID_NUMBER'], -2); // last 2 digits

        // Get total users to create a unique 4-digit registration number
        $count = User::count() + 1; // +1 for the new one
        $regNumber = str_pad($count, 4, '0', STR_PAD_LEFT); // e.g., 0020

        $membershipNumber = $year . $idSuffix . $regNumber;
        $validatedData['MEMBERSHIP_NUMBER'] = $membershipNumber;

        // generate qr code
            // Define QR code content (URL to member verification page)
        $qrUrl = route('verify.member', ['membership' => $membershipNumber]);

        // Set QR code path
        $qrPath = 'qrcodes/' . $membershipNumber . '.png';
        $fullQrPath = public_path($qrPath);

        // Create directory if it doesn't exist
        if (!file_exists(dirname($fullQrPath))) {
            mkdir(dirname($fullQrPath), 0775, true);
        }

        // Generate QR code and save as image
        QrCode::format('png')->size(200)->generate($qrUrl, $fullQrPath);

        // Handle photo upload
        if ($request->hasFile('PASSPORT_PHOTO')) {
            $file = $request->file('PASSPORT_PHOTO');
            $photoFilename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile_photos'), $photoFilename);
            $validatedData['PASSPORT_PHOTO'] = 'profile_photos/' . $photoFilename;
        }

        // Generate the membership card PDF
        $pdfDir = public_path('membership_cards');
        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0775, true);
        }
        $pdfPath = $pdfDir . '/' . $membershipNumber . '.pdf';

        // Pass absolute photo path with file:// prefix to embed image properly
        $absolutePhotoPath = public_path($validatedData['PASSPORT_PHOTO']);

        $pdf = Pdf::loadView('pdf.membership_card', [
        'name' => $validatedData['FIRST_NAME'],
        'email' => $validatedData['EMAIL'],
        'membershipNumber' => $membershipNumber,
        'SCHOOL_NAME' => $validatedData['SCHOOL_NAME'],
        'photo' => public_path($validatedData['PASSPORT_PHOTO']), // full local path
        'logo' => public_path('pictures/logo.jpg'),
        'qrCode' => public_path($qrPath), // important for PDF!
    ]);


        $pdf->save($pdfPath);

        // Create the user record in the database
        User::create($validatedData);

        // Send email with PDF attached
        Mail::to($validatedData['EMAIL'])->send(
            new MembershipCredentialsMail(
                $validatedData['EMAIL'],
                $password,
                $validatedData['FIRST_NAME'],
                $membershipNumber,
                $validatedData['PHONE_NUMBER'],
                $pdfPath // Path to the generated PDF
            )
        );

        session()->flash('success', 'Registration successful! Check your email for login credentials.');
        return redirect()->route('login');
    }
}
