<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Show form to assign permissions to a role
    public function assignPermissionsForm($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $assignedPermissions = $role->permissions->pluck('id')->toArray(); // Get assigned permissions

        return view('roles.assign-permissions', compact('role', 'permissions', 'assignedPermissions'));
    }

    // Handle form submission to assign permissions to a role
    public function assignPermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validate permissions input
        $request->validate([
            'permissions' => 'array|required',
            'permissions.*' => 'exists:permissions,id', // Ensure permission IDs are valid
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.assign-permissions')->with('success', 'Permissions updated successfully!');
    }
    // define variable role and pass it to view
    public function someView() {
        $roles = Role::all(); // Fetch all roles
        return view('assign-permissions', compact('roles'));
    }

}