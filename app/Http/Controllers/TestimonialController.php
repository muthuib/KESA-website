<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('testimonials.index', compact('testimonials'));
    }    

    public function create()
    {
        return view('testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $filename = null;
        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('testimonials'), $filename);
        }

        Testimonial::create([
            'name' => $request->name,
            'position' => $request->position,
            'content' => $request->content,
            'photo' => $filename
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial created!');
    }

    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
            'photo' => 'nullable|image'
        ]);

        $data = $request->only(['name', 'position', 'content']);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo && file_exists(public_path('testimonials/' . $testimonial->photo))) {
                unlink(public_path('testimonials/' . $testimonial->photo));
            }

            $filename = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('testimonials'), $filename);
            $data['photo'] = $filename;
        }

        $testimonial->update($data);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo && file_exists(public_path('testimonials/' . $testimonial->photo))) {
            unlink(public_path('testimonials/' . $testimonial->photo));
        }

        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('danger', 'Testimonial deleted successfully!');
    }
    public function display()
    {
        $testimonials = Testimonial::latest()->get(); // Latest first
        return view('testimonials.display', compact('testimonials'));
    }

}

