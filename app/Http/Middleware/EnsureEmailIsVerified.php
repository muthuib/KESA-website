<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout(); // Log out unverified users
                return redirect()->route('login')->with('error', 'You must verify your email to log in.');
            }

            // Check user role and redirect accordingly
            if (Auth::user()->hasRole('partner')) {
                return redirect()->route('partners.dashboard');
            } elseif (Auth::user()->hasRole('member')) {
                return redirect()->route('members.dashboard');
            }
        }

        return $next($request);
    }
}
