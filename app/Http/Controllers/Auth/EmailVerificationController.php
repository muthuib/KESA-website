<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; // Import Log class

class EmailVerificationController extends Controller
{
    /**
     * Verify the user's email.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->EMAIL_VERIFICATION) {
            return redirect()->route('login')->with('info', 'Your email is already verified.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', 'Your email has been verified!');
    }

    /**
     * Resend the verification email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerification(Request $request)
    {
        $user = User::find($request->ID);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($user->EMAIL_VERIFICATION) {
            return redirect()->back()->with('info', 'Your email is already verified.');
        }

        // Simulate sending an email
        $verificationUrl = route('verification.verify', ['ID' => $user->ID]);
        Log::info('Verification email sent to: ' . $user->EMAIL . ' URL: ' . $verificationUrl);

        return redirect()->back()->with('success', 'Verification email has been resent.');
    }
}
