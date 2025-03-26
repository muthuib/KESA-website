<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    // Display list of activities
    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')->get();
        return view('activities.index', compact('activities'));
    }

    // Show form to create a new activity
    public function create()
    {
        return view('activities.create');
    }

    // Store new activity in database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'video'       => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200', // max size in kilobytes
            'youtube_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle file upload for the video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('activities'), $videoName);
            $validated['video'] = 'activities/' . $videoName;
        }

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    // Display a single activity (video playback view)
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.show', compact('activity'));
    }

    // Show form to edit an activity
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.edit', compact('activity'));
    }

    // Update activity in database
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'video'       => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200',
            'youtube_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle video update if a new file is provided
        if ($request->hasFile('video')) {
            if ($activity->video && file_exists(public_path($activity->video))) {
                unlink(public_path($activity->video));
            }
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('activities'), $videoName);
            $validated['video'] = 'activities/' . $videoName;
        }

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    // Display all activities
    public function display()
    {
        $activities = Activity::orderBy('created_at', 'desc')->get();
        return view('activities.display', compact('activities'));
    }

    // Delete activity from database
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        if ($activity->video && file_exists(public_path($activity->video))) {
            unlink(public_path($activity->video));
        }
        $activity->delete();

        return redirect()->route('activities.index')->with('danger', 'Activity deleted successfully.');
    }
}
