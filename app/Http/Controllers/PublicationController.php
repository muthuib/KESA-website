<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    /**
     * Display a listing of the publications.
     */
    public function index()
    {
        // Fetch all publications, ordered from most recent to oldest
        $publications = Publication::latest()->get();
        return view('publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new publication.
     */
    public function create()
    {
        return view('publications.create');
    }

    /**
     * Store a newly created publication in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,txt|max:10000',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Generate a unique filename
            $filename = time() . '_' . $file->getClientOriginalName();
            // Move file to the public/publications folder
            $file->move(public_path('publications'), $filename);
            // Save the relative path to the file in the database
            $validated['file_path'] = 'publications/' . $filename;
        } else {
            return redirect()->back()->with('error', 'No file was uploaded.');
        }

        Publication::create($validated);

        return redirect()->route('publications.index')->with('success', 'Publication uploaded successfully.');
    }

    /**
     * Display the specified publication.
     */
    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified publication.
     */
    public function edit(Publication $publication)
    {
        return view('publications.edit', compact('publication'));
    }

    /**
     * Update the specified publication in storage.
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'sometimes|file|mimes:pdf,doc,docx,txt|max:10000',
        ]);

        // Handle file update if a new file is provided
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('publications'), $filename);
            $validated['file_path'] = 'publications/' . $filename;
        } else {
            $validated['file_path'] = $publication->file_path;
        }

        $publication->update($validated);

        return redirect()->route('publications.index')->with('success', 'Publication updated successfully.');
    }

    /**
     * Remove the specified publication from storage.
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();
        return redirect()->route('publications.index')->with('danger', 'Publication deleted successfully.');
    }

    /**
     * Download the specified publication file.
     */
    public function download($id)
    {
        $publication = Publication::findOrFail($id);
        $file = public_path($publication->file_path);

        return response()->download($file);
    }
    public function display()
        {
            // Fetch all publications, ordered from most recent to oldest
            $publications = Publication::latest()->get();
            return view('publications.display', compact('publications'));
        }
}
