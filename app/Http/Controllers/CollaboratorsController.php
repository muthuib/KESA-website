<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaboration;

class CollaboratorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collaborators = Collaboration::all(); // Fetch all collaborators
        return view('collaborators.index', compact('collaborators'));
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collaborators.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'logo' => 'required|image|mimes:jpg,png,jpeg,jfif|max:2048',
                'description' => 'nullable|string',
                'website' => 'nullable|url',
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('collaborators'), $filename);
                $validated['LOGO_PATH'] = 'collaborators/' . $filename; // Save relative path
            }

            Collaboration::create([
                'NAME' => $validated['name'],
                'LOGO_PATH' => $validated['LOGO_PATH'],
                'DESCRIPTION' => $validated['description'],
                'WEBSITE' => $validated['website'],
            ]);

            return redirect()->route('collaborators.index')->with('success', 'Collaborator added successfully!');
        }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCollaborations()
    {
        $collaborations = Collaboration::all(); // Fetch all collaborations
        return view('collaborations.index', compact('collaborations'));
    }
     // Alternative method to fetch collaborations
     public function fetchCollaborations()
     {
         // Fetch all collaboration records
         $collaborations = Collaboration::all();
 
         // Return the partial view with collaborations
         return view('partials.collaborations', compact('collaborations'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the collaborator by ID
        $collaborator = Collaboration::findOrFail($id);
    
        // Return the edit view with the collaborator
        return view('collaborators.edit', compact('collaborator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collaboration = Collaboration::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('collaborators'), $filename);
            $validated['LOGO_PATH'] = 'collaborators/' . $filename;
        } else {
            $validated['LOGO_PATH'] = $collaboration->LOGO_PATH; // Keep existing logo if no file is uploaded
        }

        $collaboration->update([
            'NAME' => $validated['name'],
            'LOGO_PATH' => $validated['LOGO_PATH'],
            'DESCRIPTION' => $validated['description'],
            'WEBSITE' => $validated['website'],
        ]);

        return redirect()->route('collaborators.index')->with('success', 'Collaborator updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collaboration = Collaboration::findOrFail($id);
        $collaboration->delete();

        return redirect()->route('collaborators.index')->with('danger', 'Collaborator deleted successfully!');
    }


}
