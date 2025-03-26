<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Founder;

class FounderController extends Controller
{
    // Display a listing of founders.
    public function index()
    {
        $founders = Founder::all();
        return view('founders.index', compact('founders'));
    }

    // Show the form for creating a new founder.
    public function create()
    {
        return view('founders.create');
    }

    // Store a newly created founder in storage.
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
            $image->move(public_path('founders'), $imageName);
            $imagePath = 'founders/' . $imageName;
        } else {
            return redirect()->back()->with('error', 'Image upload required.');
        }

        Founder::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'bio'         => $request->bio,
            'cv_link'     => $request->cv_link,
            'image'       => $imagePath,
        ]);

        return redirect()->route('founders.index')->with('success', 'Founder added successfully.');
    }

    // Display the specified founder.
    public function show(Founder $founder)
    {
        return view('founders.show', compact('founder'));
    }

    // Show the form for editing the specified founder.
    public function edit(Founder $founder)
    {
        return view('founders.edit', compact('founder'));
    }

    // Update the specified founder in storage.
    public function update(Request $request, Founder $founder)
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
            $image->move(public_path('founders'), $imageName);
            $data['image'] = 'founders/' . $imageName;
        }

        $founder->update($data);

        return redirect()->route('founders.index')->with('success', 'Founder updated successfully.');
    }

    // Remove the specified founder from storage.
    public function destroy(Founder $founder)
    {
        $founder->delete();
        return redirect()->route('founders.index')->with('danger', 'Founder deleted successfully.');
    }

    // Display founders in a public view.
    public function display()
    {
        $founders = Founder::all();
        return view('founders.display', compact('founders'));
    }
}
