<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Executive;

class ExecutiveController extends Controller
{
    // Display a listing of executives.
    public function index()
    {
        $executives = Executive::all();
        return view('executives.index', compact('executives'));
    }

    // Show the form for creating a new executive.
    public function create()
    {
        return view('executives.create');
    }

    // Store a newly created executive in storage.
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
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('executives'), $imageName);
            $imagePath = 'executives/' . $imageName;
        } else {
            return redirect()->back()->with('error', 'Image upload required.');
        }

        Executive::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'bio'         => $request->bio,
            'cv_link'     => $request->cv_link,
            'image'       => $imagePath,
        ]);

        return redirect()->route('executives.index')->with('success', 'Executive added successfully.');
    }

    // Display the specified executive.
    public function show(Executive $executive)
    {
        return view('executives.show', compact('executive'));
    }

    // Show the form for editing the specified executive.
    public function edit(Executive $executive)
    {
        return view('executives.edit', compact('executive'));
    }

    // Update the specified executive in storage.
    public function update(Request $request, Executive $executive)
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
            $image->move(public_path('executives'), $imageName);
            $data['image'] = 'executives/' . $imageName;
        }

        $executive->update($data);

        return redirect()->route('executives.index')->with('success', 'Executive updated successfully.');
    }

    // Remove the specified executive from storage.
    public function destroy(Executive $executive)
    {
        $executive->delete();
        return redirect()->route('executives.index')->with('danger', 'Executive deleted successfully.');
    }

    // Display executives in a public view.
    public function display()
    {
        $executives = Executive::all(); // Fetch Executives
        return view('executives.display', compact('executives'));
        
    }
}
