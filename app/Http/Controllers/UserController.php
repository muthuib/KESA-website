<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //assign roles form method
    public function assignRolesForm($id)
{
    $user = User::with('roles')->findOrFail($id);
    $roles = Role::all();

    return view('users.assign_roles', compact('user', 'roles'));
}

//assign role logic
public function assignRoles(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id',
    ]);

    // Sync roles to user
    $user->roles()->sync($request->roles);

    return redirect()->route('users.index')->with('success', 'Roles updated successfully!');
}


}
