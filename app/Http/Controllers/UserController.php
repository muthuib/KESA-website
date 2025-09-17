<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Assign roles form method
    public function assignRolesForm($id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();

        return view('users.assign_roles', compact('user', 'roles'));
    }

    // Assign role logic (only one role via radio)
  public function assignRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|exists:roles,id',
        ]);

        // Since it's a belongsTo, just update the foreign key
        $user->role_id = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Role updated successfully!');
   }

 public function updateTheme(Request $request)
    {
        $request->validate([
            'themeMode' => 'required|in:light,dark',
        ]);

        $user = auth()->user();

        DB::table('users')
            ->where('ID', $user->ID) // 👈 use uppercase ID
            ->update(['theme_mode' => $request->themeMode]);

        return back()->with('success', 'Theme updated successfully!');
    }

}
