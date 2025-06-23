<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\File;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::latest()->get();
        return view('publications.index', compact('publications'));
    }

    public function display()
    {
        $publications = Publication::latest()->get();
        return view('publications.display', compact('publications'));
    }

    public function create()
    {
        return view('publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'authors'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,txt|max:10000',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'publications/' . $fileName;
            
            $fileSize = $file->getSize(); // ✅ Get size before moving
            $file->move(public_path('publications/'), $fileName);

            $validated['file_path'] = $filePath;
            $validated['file_size'] = $fileSize;
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }

        $validated['downloads'] = 0;
        Publication::create($validated);

        return redirect()->route('publications.index')->with('success', 'Publication uploaded successfully.');
    }

    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication)
    {
        return view('publications.edit', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'authors'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'sometimes|file|mimes:pdf,doc,docx,txt|max:10000',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
        
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'publications/' . $filename;
        
            // Get the size BEFORE moving
            $validated['file_size'] = $file->getSize(); 
        
            // Move the file
            $file->move(public_path('publications'), $filename);
        
            $validated['file_path'] = $filePath;
        
        } else {
            $validated['file_path'] = $publication->file_path;
            $validated['file_size'] = $publication->file_size;
        }
        

        $publication->update($validated);

        return redirect()->route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication)
    {
        // Delete the file
        if (File::exists(public_path($publication->file_path))) {
            File::delete(public_path($publication->file_path));
        }

        $publication->delete();
        return redirect()->route('publications.index')->with('danger', 'Publication deleted successfully.');
    }

    public function download($id)
    {
        $publication = Publication::findOrFail($id);
        $file = public_path($publication->file_path);

        if (!file_exists($file)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $publication->increment('downloads');

        return response()->download($file, $publication->title . '.' . pathinfo($file, PATHINFO_EXTENSION));
    }
}
