<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::all();
        return view('memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memberships.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('collaborators'), $filename);
            $logoPath = 'collaborators/' . $filename;
        } else {
            $logoPath = null;
        }

        $membership = new Membership();
        $membership->NAME = $validated['name'];
        $membership->LOGO_PATH = $logoPath;
        $membership->DESCRIPTION = $validated['description'] ?? null;
        $membership->WEBSITE = $validated['website'] ?? null;
        $membership->save();

        return redirect()->route('memberships.index')->with('success', 'Membership added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function showMemberships()
    {
        $memberships = Membership::all();
        return view('memberships.index', compact('memberships'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        return view('memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('collaborators'), $filename);
            $membership->LOGO_PATH = 'collaborators/' . $filename;
        }

        // Assign updated values
        $membership->NAME = $validated['name'];
        $membership->DESCRIPTION = $validated['description'] ?? null;
        $membership->WEBSITE = $validated['website'] ?? null;

        // Save the changes
        $membership->save();

        return redirect()->route('memberships.index')->with('success', 'Membership updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();

        return redirect()->route('memberships.index')->with('danger', 'Membership deleted successfully!');
    }
}
