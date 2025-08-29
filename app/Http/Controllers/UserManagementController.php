<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
 public function index()
    {
        $students = User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        })->get();

        $associates = User::whereHas('role', function ($q) {
            $q->where('name', 'associate');
        })->get();

        $full = User::whereHas('role', function ($q) {
            $q->where('name', 'full');
        })->get();

        $honorary = User::whereHas('role', function ($q) {
            $q->where('name', 'honorary');
        })->get();

        $organization = User::whereHas('role', function ($q) {
            $q->where('name', 'organization');
        })->get();

        $unassigned = User::whereDoesntHave('role')->get();

         $admins = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->get();

        return view('users.index', compact(
            'students',
            'associates',
            'full',
            'honorary',
            'organization',
            'unassigned',
             'admins'
        ));
    }


    /**
     * View a user.
     */
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'USERNAME' => 'required|string|unique:users,USERNAME',
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            'CATEGORY' => 'required|string|max:255',
            'COURSE' => 'required|string|max:255',
            'UNIVERSITY' => 'required|string|max:255',
            'PASSWORD_HASH' => 'required|string|min:8|confirmed',
            'ROLE' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'USERNAME' => $request->USERNAME,
            'FIRST_NAME' => $request->FIRST_NAME,
            'LAST_NAME' => $request->LAST_NAME,
            'EMAIL' => $request->EMAIL,
            'CATEGORY' => $request->CATEGORY,
            'COURSE' => $request->COURSE,
            'UNIVERSITY' => $request->UNIVERSITY,
            'PASSWORD_HASH' => bcrypt($request->PASSWORD_HASH),
        ]);

        // Assign role
        $role = Role::where('name', $request->ROLE)->first();
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $categories = User::select('CATEGORY')->distinct()->pluck('CATEGORY')->toArray();
        $categories[] = 'Ongoing Student';
        $categories[] = 'Graduate';

        return view('users.edit', compact('user', 'roles', 'categories'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'USERNAME' => 'required|string|unique:users,USERNAME,' . $id,
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:users,EMAIL,' . $id,
            'CATEGORY' => 'required|string|max:255',
            'COURSE' => 'required|string|max:255',
            'UNIVERSITY' => 'required|string|max:255',
            'PASSWORD_HASH' => 'nullable|string|min:8|confirmed',
            'ROLE' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'USERNAME' => $request->USERNAME,
            'FIRST_NAME' => $request->FIRST_NAME,
            'LAST_NAME' => $request->LAST_NAME,
            'EMAIL' => $request->EMAIL,
            'CATEGORY' => $request->CATEGORY,
            'COURSE' => $request->COURSE,
            'UNIVERSITY' => $request->UNIVERSITY,
            'PASSWORD_HASH' => $request->filled('PASSWORD_HASH') ? bcrypt($request->PASSWORD_HASH) : $user->PASSWORD_HASH,
        ]);

        // Sync role
        $role = Role::where('name', $request->ROLE)->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('danger', 'User deleted successfully.');
    }
}
