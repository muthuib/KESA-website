<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'EMAIL' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['EMAIL' => $credentials['EMAIL'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            // ✅ Membership expiry check (Africa/Nairobi timezone)
            $now = now('Africa/Nairobi');
            $expiry = Carbon::parse($user->membership_expiry, 'Africa/Nairobi');

            if (!$user->membership_expiry || $expiry->lt($now)) {
                Auth::logout();
                return redirect()->route('membership.renew.form')
                    ->with('error', 'Your membership has expired. Please renew to continue.');
            }

            // ✅ Must change password
            if ($user->must_change_password) {
                return redirect()->route('password.change');
            }

            // ✅ Success login message
            session()->flash('success', 'You have logged in successfully. Welcome, ' . $user->FIRST_NAME . ' ' . $user->LAST_NAME . ' to KESA');

            // ✅ Redirect to user dashboard (protected by middleware)
            return redirect()->intended('/user-dashboard');
        }

        // ❌ Authentication failed
        return back()->withErrors([
            'EMAIL' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
