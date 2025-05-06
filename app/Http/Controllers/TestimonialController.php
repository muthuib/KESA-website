<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('date', 'desc')->get();
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
            'position' => 'nullable|string',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'nullable|date'
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
            'photo' => $filename,
            'date' => $request->date
        ]);
    
        return redirect()->route('testimonials.index')->with('success', 'Testimonial Added successfully!');
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
            'position' => 'nullable|string',
            'content' => 'required|string',
            'photo' => 'nullable|image',
            'date' => 'nullable|date'
        ]);
    
        $data = $request->only(['name', 'position', 'content', 'date']);
    
        if ($request->hasFile('photo')) {
            if ($testimonial->photo && file_exists(public_path('testimonials/' . $testimonial->photo))) {
                unlink(public_path('testimonials/' . $testimonial->photo));
            }
    
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('testimonials'), $filename);
            $data['photo'] = $filename;
        }
    
        $testimonial->update($data);
    
        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully!');
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
        $testimonials = Testimonial::orderBy('date', 'desc')->get(); // Latest date first
        return view('testimonials.display', compact('testimonials'));
    }
    
}

