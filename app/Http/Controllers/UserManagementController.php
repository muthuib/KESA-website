<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')->get(); // Load users along with their roles
        return view('users.index', compact('users'));
    }
/**
     * View user.
     */
    public function show($id)
{
    $user = User::with('roles')->findOrFail($id); // Fetch user with roles

    return view('users.show', compact('user'));
}

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'USERNAME' => 'required|string|unique:users,USERNAME',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            'PASSWORD_HASH' => 'required|string|min:8|confirmed',
            'ROLE' => 'required|string|exists:roles,name',
        ]);
    
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Create the user
        $user = new User();
        $user->USERNAME = $request->USERNAME;
        $user->EMAIL = $request->EMAIL;
        $user->PASSWORD_HASH = bcrypt($request->PASSWORD_HASH);
        $user->save();
    
        // Assign role
        $role = Role::where('name', $request->ROLE)->first();
        $user->roles()->attach($role);
    
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all(); // Fetch all roles
        return view('users.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'USERNAME' => 'required|unique:users,USERNAME,' . $id, // Ignore current user's username
            'EMAIL' => 'required|email|unique:users,EMAIL,' . $id, // Ignore current user's email
            'PASSWORD_HASH' => 'nullable|min:8', // Password is optional, but must be at least 8 characters
        ]);
    
        $user->USERNAME = $request->USERNAME;
        $user->EMAIL = $request->EMAIL;
    
        if ($request->filled('PASSWORD_HASH')) {
            $user->PASSWORD_HASH = bcrypt($request->PASSWORD_HASH);
        }
    
        $user->roles()->sync([$request->role_id]); // Update roles
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }    

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('danger', 'User deleted successfully.');
    }
}
