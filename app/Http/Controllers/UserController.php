<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

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

}
