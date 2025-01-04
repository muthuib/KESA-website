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
            'FIRST_NAME' => 'required|string|:users,FIRST_NAME',
            'LAST_NAME' => 'required|string|:users,LAST_NAME',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            'CATEGORY' => 'required|string|max:255',
            'COURSE' => 'required|string|max:255',
            'UNIVERSITY' => 'required|string|max:255',
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
        $user->FIRST_NAME = $request->FIRST_NAME;
        $user->LAST_NAME = $request->LAST_NAME;
        $user->EMAIL = $request->EMAIL;
        $user->CATEGORY = $request->CATEGORY;
        $user->COURSE = $request->COURSE;
        $user->UNIVERSITY = $request->UNIVERSITY;
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
        $user = User::with('roles')->findOrFail($id); // Fetch the user with their role
        $roles = Role::all(); // Fetch all roles
        $categories = User::select('CATEGORY')->distinct()->pluck('CATEGORY')->toArray(); // Get unique categories
        $categories[] = 'Ongoing Student'; // Add "Ongoing Student" option
        $categories[] = 'Graduate'; // Add "graduate Student" option
    
        return view('users.edit', compact('user', 'roles', 'categories'));
    }
    
    
    


    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'USERNAME' => 'required|unique:users,USERNAME,' . $id, // Ignore current user's username
            'FIRST_NAME' => 'required|string|:users,FIRST_NAME',
            'LAST_NAME' => 'required|string|:users,LAST_NAME,',
            'CATEGORY' => 'required|string|:users,CATEGORY,',
            'COURSE' => 'required|string|:users,COURSE,',
            'UNIVERSITY' => 'required|string|:users,UNIVERSITY,',
            'EMAIL' => 'required|email|unique:users,EMAIL,' . $id, // Ignore current user's email
            'PASSWORD_HASH' => 'nullable|min:8', // Password is optional, but must be at least 8 characters
        ]);
    
        $user->USERNAME = $request->USERNAME;
        $user->FIRST_NAME = $request->FIRST_NAME;
        $user->LAST_NAME = $request->LAST_NAME;
        $user->EMAIL = $request->EMAIL;
        $user->CATEGORY = $request->CATEGORY;
        $user->COURSE = $request->COURSE;
        $user->UNIVERSITY = $request->UNIVERSITY;
    
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
