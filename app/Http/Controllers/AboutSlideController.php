<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutSlide;

class AboutSlideController extends Controller
{
    // Display a listing of slides.
    public function index()
    {
        $slides = AboutSlide::all();
        return view('about_slides.index', compact('slides'));
    }

    // Show the form for creating a new slide.
    public function create()
    {
        return view('about_slides.create');
    }

    // Store a newly created slide in storage.
    public function store(Request $request)
    {
        $request->validate([
            'slide_image' => 'required|image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
            'caption'     => 'required|string|max:255',
        ]);

        // Handle file upload.
        if ($request->hasFile('slide_image')) {
            $image = $request->file('slide_image');
            // Generate a unique filename using time() and the original file name.
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Move the image to the public/about_slides folder.
            $image->move(public_path('about_slides'), $imageName);
            // Construct the relative path for the database.
            $imagePath = 'about_slides/' . $imageName;
        } else {
            return redirect()->back()->with('error', 'No image was uploaded.');
        }

        AboutSlide::create([
            'IMAGE_PATH' => $imagePath,
            'CAPTION'    => $request->caption,
        ]);

        return redirect()->route('about-slides.index')->with('success', 'Slide uploaded successfully.');
    }

    // Display the specified slide.
    public function show(AboutSlide $aboutSlide)
    {
        return view('about_slides.show', compact('aboutSlide'));
    }

    // Show the form for editing the specified slide.
    public function edit(AboutSlide $aboutSlide)
    {
        return view('about_slides.edit', compact('aboutSlide'));
    }

    // Update the specified slide in storage.
    public function update(Request $request, AboutSlide $aboutSlide)
    {
        $request->validate([
            'caption'     => 'required|string|max:255',
            'slide_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
        ]);

        $data = ['CAPTION' => $request->caption];

        // Handle file upload if a new image is provided.
        if ($request->hasFile('slide_image')) {
            $image = $request->file('slide_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('about_slides'), $imageName);
            $data['IMAGE_PATH'] = 'about_slides/' . $imageName;
        }

        $aboutSlide->update($data);

        return redirect()->route('about-slides.index')->with('success', 'Slide updated successfully.');
    }

    // Remove the specified slide from storage.
    public function destroy(AboutSlide $aboutSlide)
    {
        $aboutSlide->delete();
        return redirect()->route('about-slides.index')->with('danger', 'Slide deleted successfully.');
    }
}
