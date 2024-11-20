<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'TITLE' => 'required|string|max:255',
        'DESCRIPTION' => 'nullable|string',
        'FILE' => 'required|file|mimes:pdf,doc,docx', // Adjust file types
        'PRICE' => 'nullable|numeric|min:0',
    ]);

    // Handle File Upload
    $filePath = $request->file('FILE')->store('resources'); // Stores in the "storage/app/resources" directory

    // Save to Database
    $resource = Resource::create([
        'TITLE' => $request->TITLE,
        'DESCRIPTION' => $request->DESCRIPTION,
        'FILE_PATH' => $filePath,
        'PRICE' => $request->PRICE ?? 0,
    ]);

    return response()->json([
        'success' => true,
        'data' => $resource,
    ]);
}
//index function
public function index()
{
    // Fetch all resources and return the index view
    $resources = Resource::all();
    return view('resource.index', compact('resource')); // Adjust the view path as needed
}
//function to hadle resource form 
public function create()
{
    return view('resource.create'); // Adjust the view path as needed
}
//show function
public function show($id)
{
    // Find the resource by ID
    $resource = Resource::findOrFail($id);

    // Return a view to display the resource details
    return view('resource.show', compact('resource')); // Adjust the view path as needed
}

}
