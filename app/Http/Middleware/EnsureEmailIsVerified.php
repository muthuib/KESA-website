<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            Auth::logout(); // Log out unverified users
            return redirect()->route('login')->with('error', 'You must verify your email to log in.');
        }

        return $next($request);
    }
}
