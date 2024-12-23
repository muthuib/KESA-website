<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PartnerLoginController extends Controller
{
    /**
     * Show the login form for partners.
     */
    public function showLoginForm()
    {
        return view('auth.partnerlogin');
    }

    /**
     * Handle partner login.
     */
    public function partnerlogin(Request $request)
    {
        // Validate the login request
        $credentials = $request->validate([
            'EMAIL' => 'required|email',
            'PASSWORD' => 'required|string',
        ]);

        // Attempt to authenticate using the 'partner' guard
        if (Auth::guard('partner')->attempt(['EMAIL' => $credentials['EMAIL'], 'PASSWORD' => $credentials['PASSWORD']])) {
            // Retrieve the authenticated partner
            $partner = Auth::guard('partner')->user();

            // Set a success message in session
            session()->flash('success', 'You have logged in successfully. Welcome, ' . $partner->COMPANY_NAME . ' to Kenya Economics Students Association (KESA) Kenya.');

            return redirect()->intended('/app');
        }

        // Return back with an error if authentication fails
        return back()->withErrors([
            'EMAIL' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout the authenticated partner.
     */
    public function logout(Request $request)
    {
        // Logout the 'partner' guard
        Auth::guard('partner')->logout();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect('/auth.partnerlogin')->with('success', 'You have been logged out successfully.');
    }
}
