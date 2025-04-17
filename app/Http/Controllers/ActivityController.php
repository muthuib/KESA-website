<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')->get();
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'activity_title'=> 'nullable|string|max:255',
            'name'          => 'nullable|string|max:255',
            'location'      => 'nullable|string|max:255',
            'date'          => 'nullable|date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i',
            'media'         => 'nullable|file|mimes:mp4,avi,mov,wmv,jpg,jpeg,png,gif,webp|max:51200',
            'media1'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'media2'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'media3'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'youtube_link'  => 'nullable|url|max:255',
            'description'   => 'nullable|string',
        ]);

        // Handle media files upload
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaName = time() . '.' . $media->getClientOriginalExtension();
            $media->move(public_path('activities'), $mediaName);
            $validated['media'] = 'activities/' . $mediaName;
        }

        // Handle media1, media2, media3 uploads
        foreach (['media1', 'media2', 'media3'] as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('activities'), $filename);
                $validated[$key] = 'activities/' . $filename;
            }
        }

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.show', compact('activity'));
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'activity_title'=> 'nullable|string|max:255',
            'name'          => 'nullable|string|max:255',
            'location'      => 'nullable|string|max:255',
            'date'          => 'nullable|date',
            'start_time'    => 'nullable',
            'end_time'      => 'nullable',
            'media'         => 'nullable|file|mimes:mp4,avi,mov,wmv,jpg,jpeg,png,gif,webp|max:51200',
            'media1'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'media2'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'media3'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
            'youtube_link'  => 'nullable|url|max:255',
            'description'   => 'nullable|string',
        ]);

        // Delete old media files if they exist
        foreach (['media', 'media1', 'media2', 'media3'] as $key) {
            if ($request->hasFile($key)) {
                if ($activity->$key && file_exists(public_path($activity->$key))) {
                    unlink(public_path($activity->$key));
                }
            }
        }

        // Handle new media files upload
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaName = time() . '.' . $media->getClientOriginalExtension();
            $media->move(public_path('activities'), $mediaName);
            $validated['media'] = 'activities/' . $mediaName;
        }

        foreach (['media1', 'media2', 'media3'] as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('activities'), $filename);
                $validated[$key] = 'activities/' . $filename;
            }
        }

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function display()
    {
        $activities = Activity::orderBy('created_at', 'desc')->get();
        return view('activities.display', compact('activities'));
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        // Delete media files
        foreach (['media', 'media1', 'media2', 'media3'] as $key) {
            if ($activity->$key && file_exists(public_path($activity->$key))) {
                unlink(public_path($activity->$key));
            }
        }

        $activity->delete();

        return redirect()->route('activities.index')->with('danger', 'Activity deleted successfully.');
    }
}
