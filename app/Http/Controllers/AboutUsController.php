<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first(); // Fetch the first record
        return view('about.index', compact('aboutUs'));
    }

    public function edit()
    {
        $aboutUs = AboutUs::first();
        return view('about.edit', compact('aboutUs'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'CONTENT' => 'required|string',
        ]);

        $aboutUs = AboutUs::firstOrNew();
        $aboutUs->fill($validated);
        $aboutUs->save();

        return redirect()->route('about.index')->with('success', 'About Us updated successfully!');
    }
}

