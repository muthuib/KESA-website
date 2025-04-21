<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\TemporaryPasswordMail; // ✅ Add this at the top

class ForgotPasswordController extends Controller
{
    // Show form for requesting password reset
    public function showForgotForm() {
        return view('auth.forgot-password');
    }

    // Handle sending a temporary password
    public function sendTemporaryPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,EMAIL'
        ]);
    
        // Generate a temporary password
        $tempPassword = strtoupper(str()->random(8)); // Make the temp password uppercase
    
        // Find the user
        $user = User::where('EMAIL', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }
    
        // Hash the temporary password and save it
        $user->PASSWORD_HASH = Hash::make($tempPassword);
        $user->must_change_password = true; // Flag that the password needs to be changed after login
        $user->save();
    
        // Send the temporary password via email using the Mailable class
        Mail::to($user->EMAIL)->send(new TemporaryPasswordMail($tempPassword));
    
        return redirect()->route('login')->with('success', 'A temporary password has been sent to your email.');
    }

    // Show change password form
    public function showChangePasswordForm() {
        return view('auth.change-password');
    }

    // Handle password change
    public function changePassword(Request $request) {
        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ]);

        // Get the current authenticated user
        $user = Auth::user();
        
        // Update password and flag
        $user->PASSWORD_HASH = Hash::make($request->new_password); // Use PASSWORD_HASH instead of password
        $user->must_change_password = false; // Reset the change password flag
        $user->save();

        return redirect('/user-dashboard')->with('success', 'Password changed successfully.');
    }
}
