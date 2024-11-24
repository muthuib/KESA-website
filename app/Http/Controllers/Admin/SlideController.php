<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // For file handling
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        // Fetch all slides from the database
        $slides = Slide::all();
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        // Return the create slide view
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Handle the uploaded image
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Move the image to the 'public/slides' directory
        $image->move(public_path('slides'), $imageName);

        // Save the slide information to the database
        Slide::create([
            'IMAGE_PATH' => 'slides/' . $imageName, // Store path relative to 'public'
            'CAPTION' => $request->caption,
        ]);

        // Redirect back to the slides index with success message
        return redirect()->route('admin.slides.index')->with('success', 'Slide added successfully!');
    }

    public function destroy(Slide $slide)
    {
        // Check if the image file exists in the 'public/slides' directory
        $imagePath = public_path($slide->IMAGE_PATH);
        if (File::exists($imagePath)) {
            File::delete($imagePath); // Delete the file
        }

        // Delete the database record
        $slide->delete();

        // Redirect back with a success message
        return redirect()->route('admin.slides.index')->with('danger', 'Slide deleted successfully!');
    }
}
