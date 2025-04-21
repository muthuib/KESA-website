<?php

// ChangePasswordController.php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

     // Handle password change
     public function changePassword(Request $request) {
        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->must_change_password = false;
        $user->save();

        return redirect('/user-dashboard')->with('success', 'Password changed successfully.');
    }
}
