<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::all();
        return view('admin.slides.index', compact('slides'));
    }

    public function show($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.show', compact('slide'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'required|string|max:255',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('slides'), $imageName);

        Slide::create([
            'IMAGE_PATH' => 'slides/' . $imageName,
            'CAPTION' => $request->caption,
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide added successfully!');
    }

  
   // Show edit form
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.edit', compact('slide'));
    }

    // Update slide
    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);

        $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slide->CAPTION = $request->input('caption');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slides', 'public');
            $slide->IMAGE_PATH = 'storage/' . $imagePath;
        }

        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(Slide $slide)
    {
        $imagePath = public_path($slide->IMAGE_PATH);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')->with('danger', 'Slide deleted successfully!');
    }
}
