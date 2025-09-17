<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // Get logged-in user
        $user = Auth::user();

        // If you also want student details (assuming relation exists in User model)
        // $student = $user->student ?? null;

        return view('profile', compact('user'));
    }
}
