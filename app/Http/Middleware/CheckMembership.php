<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckMembership
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && (
            !$user->membership_expiry ||
            Carbon::parse($user->membership_expiry)->lte(now())
        )) {
            Auth::logout();

            return redirect()->route('membership.renew')
                ->with('error', 'Your membership has expired. Please renew.');
        }

        return $next($request);
    }
}
