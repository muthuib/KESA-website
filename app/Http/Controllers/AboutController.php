<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\AboutSlide;
use App\Models\TeamMember;

class AboutController extends Controller
{
    /**
     * Show the About Us page.
     */
    public function index()
    {
        $about = About::first();
        return view('about.index', ['about' => $about ?? new About()]);
    }
       // Show the "Add About Us" form
       public function create()
       {
           return view('about.create');
       }
   
       // Store the new About Us data
       public function store(Request $request)
       {
           // Validate the form input
           $request->validate([
               'vision' => 'required|string|max:255',
               'mission' => 'required|string|max:255',
               'objectives' => 'required|string|max:255',
               'motto' => 'required|string|max:255',
               'about' => 'required|string|max:255',
               'belief' => 'required|string|max:255',
           ]);
   
           // Create a new About Us entry
           About::create([
               'VISION' => $request->vision,
               'MISSION' => $request->mission,
               'OBJECTIVES' => $request->objectives,
               'MOTTO' => $request->motto,
               'ABOUT' => $request->about,
               'BELIEF' => $request->belief,
           ]);
   
           return redirect()->route('about.index')->with('success', 'About Us created successfully.');
       }

    /**
     * Show the edit form for About Us.
     */
    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('about.edit', compact('about'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'vision' => 'required|string|',
            'mission' => 'required|string|',
            'objectives' => 'required|string|',
            'motto' => 'required|string|',
            'about' => 'required|string|',
            'belief' => 'required|string|',
        ]);
    
        $about = About::findOrFail($id);
        $about->update([
            'VISION' => $request->vision,
            'MISSION' => $request->mission,
            'OBJECTIVES' => $request->objectives,
            'MOTTO' => $request->motto,
            'ABOUT' => $request->about,
            'BELIEF' => $request->belief,
        ]);
    
        return redirect()->route('about.index')->with('success', 'About Us updated successfully.');
    }
    
    /**
     * Show only the Vision page.
     */
    public function vision()
    {
        $about = About::first();
        return view('about.vision', compact('about'));
    }

    /**
     * Show only the Mission page.
     */
    public function mission()
    {
        $about = About::first();
        return view('about.mission', compact('about'));
    }

    /**
     * Show only the Objectives page.
     */
    public function objectives()
    {
        $about = About::first();
        return view('about.objectives', compact('about'));
    }
     /**
     * Show only the Objectives page.
     */
    public function about()
    {
        $about = About::first();
        return view('about.about', compact('about'));
    }
     /**
     * Show only the Objectives page.
     */
    public function motto()
    {
        $about = About::first();
        return view('about.motto', compact('about'));
    }
     /**
     * Show only the Objectives page.
     */
    public function belief()
    {
        $about = About::first();
        return view('about.belief', compact('about'));
    }
    public function display()
        {
            $about = About::first();
            $slides = AboutSlide::all();
            $teamMembers = TeamMember::all(); // Retrieve team members dynamically

            return view('about.display', compact('about', 'slides', 'teamMembers'));
        }

        public function destroy($id)
    {
        // Find the 'About Us' record
        $about = About::findOrFail($id);

        // Delete the record
        $about->delete();

        // Redirect back with success message
        return redirect()->route('about.index')->with('danger', '"About Us" record deleted successfully.');
    }
}
