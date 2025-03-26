<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\Executive;

class TeamMemberController extends Controller
{
    // Display a listing of team members.
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('team_members.index', compact('teamMembers'));
    }

    // Show the form for creating a new team member.
    public function create()
    {
        return view('team_members.create');
    }

    // Store a newly created team member in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'cv_link'     => 'nullable|url',
            'image'       => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Generate a unique filename.
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Move the file to public/team_members folder.
            $image->move(public_path('team_members'), $imageName);
            // Set the relative file path.
            $imagePath = 'team_members/' . $imageName;
        } else {
            return redirect()->back()->with('error', 'Image upload required.');
        }

        TeamMember::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'bio'         => $request->bio,
            'cv_link'     => $request->cv_link,
            'image'       => $imagePath,
        ]);

        return redirect()->route('team-members.index')->with('success', 'Team member added successfully.');
    }

    // Display the specified team member.
    public function show(TeamMember $teamMember)
    {
        return view('team_members.show', compact('teamMember'));
    }

    // Show the form for editing the specified team member.
    public function edit(TeamMember $teamMember)
    {
        return view('team_members.edit', compact('teamMember'));
    }

    // Update the specified team member in storage.
    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'cv_link'     => 'nullable|url',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'designation' => $request->designation,
            'bio'         => $request->bio,
            'cv_link'     => $request->cv_link,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('team_members'), $imageName);
            $data['image'] = 'team_members/' . $imageName;
        }

        $teamMember->update($data);

        return redirect()->route('team-members.index')->with('success', 'Team member updated successfully.');
    }

    // Remove the specified team member from storage.
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('team-members.index')->with('danger', 'Team member deleted successfully.');
    }
    public function display()
    {
        $teamMembers = TeamMember::all(); // Fetch all team members
        return view('team_members.display', compact('teamMembers'));
    }
}
