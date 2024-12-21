<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Symfony\Contracts\Service\Attribute\Required;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::all();  // Fetch all resources
        return view('resources.index', compact('resources'));  // Pass them to the view
    }
    //function to display resources to end users
    public function showResources()
    {
        $resources = Resource::paginate(3); // Fetch 3 resources per page
        return view('resources.show', compact('resources'));
    }

//function to create or add new resource
    public function create()
    {
        return view('resources.create');
    }
//function to save new resource to database
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
           'FILE_PATH' => 'nullable|file|mimes:jpeg,png,jpg,pdf,mp4,gif,svg',
            'PRICE' => 'required|numeric',
            'TYPE' => 'required|in:pdf,video,article', // Allow only the specified types
        ]);

        // Handle the image upload if an image is present
        if ($request->hasFile('FILE_PATH')) {
            $image = $request->file('FILE_PATH');

            // Generate a unique filename for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the image to the public 'images' folder
            $image->move(public_path('images'), $imageName);

            // Store the relative file path in the database
            $validated['FILE_PATH'] = 'images/' . $imageName;  // Store relative path
        }

        // Create the resource record in the database
        Resource::create($validated);

        // Redirect to resources index with a success message
        return redirect()->route('resources.index')->with('success', 'New Resource Added successfully.');
    }
//function to edit resource
    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }
//function to update edited resource
    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
           'FILE_PATH' => 'nullable|file|mimes:jpeg,png,jpg,pdf,mp4,gif,svg',
            'PRICE' => 'required|numeric',
            'TYPE' => 'required|in:pdf,video,article', // Allow only the specified types
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('FILE_PATH')) {
            // Delete the old image if exists
            if ($resource->FILE_PATH && file_exists(public_path($resource->FILE_PATH))) {
                unlink(public_path($resource->FILE_PATH)); // Delete old file
            }

            $image = $request->file('FILE_PATH');
            // Generate a unique filename
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the image to the public 'images' folder
            $image->move(public_path('images'), $imageName);

            // Save the new image path
            $validated['FILE_PATH'] = 'images/' . $imageName;
        } else {
            // If no new file is uploaded, retain the old file path
            $validated['FILE_PATH'] = $resource->FILE_PATH;
        }

        // Update the resource record with the validated data
        $resource->update($validated);

        return redirect()->route('resources.index')->with('success', 'Resource updated successfully.');
    }
//function to view a resource
    public function view(Resource $resource)
    {
        return view('resources.view', compact('resource'));
    }

//function to delete a resource
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')->with('danger', 'Resource deleted successfully.');
    }
}