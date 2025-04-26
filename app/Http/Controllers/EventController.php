<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventController extends Controller
{
    // Show list of events
    public function index()
    {
        $events  = Event::orderBy('created_at', 'desc')->get();
        return view('events.index', compact('events'));
    }

    // Show form to create a new event
    public function create()
    {
        return view('events.create');
    }

    // Store new event data
    public function store(Request $request)
        {
            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                // 'location' => 'required|string|max:255',
                'link' => 'nullable|string|max:255',
                'venue' => 'required|string|max:255',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,jfif,gif|max:2048', // Validate image
            ]);

            // Handle image upload to public/events
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('events'), $filename);
                $imagePath = 'events/' . $filename; // Save relative path
            }

            // Ensure start_time and end_time are formatted correctly
            $start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i');
            $end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i');

            // Create the event
            Event::create([
                'name' => $request->name,
                // 'location' => $request->location,
                'link' => $request->link,
                'venue' => $request->venue,
                'start_date' => $request->start_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'description' => $request->description,
                'image' => $imagePath, // Save image path
            ]);

            return redirect()->route('events.index')->with('success', 'Event created successfully!');
        }


    // Show form to edit an existing event
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Update the event data
    public function update(Request $request, Event $event)
        {
            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                // 'location' => 'required|string|max:255',
                'link' => 'nullable|string|max:255',
                'venue' => 'required|string|max:255',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,jfif,gif|max:2048', // Validate image
            ]);

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($event->image && file_exists(public_path($event->image))) {
                    unlink(public_path($event->image));
                }

                // Store new image in public/events
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('events'), $filename);
                $event->image = 'events/' . $filename; // Update image path
            }

            // Ensure start_time and end_time are formatted correctly
            $start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i');
            $end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i');

            // Update the event
            $event->update([
                'name' => $request->name,
                // 'location' => $request->location,
                'link' => $request->link,
                'venue' => $request->venue,
                'start_date' => $request->start_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'description' => $request->description,
            ]);

            return redirect()->route('events.index')->with('success', 'Event updated successfully!');
        }


    // Show details of a specific event
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Delete an event
    public function destroy(Event $event)
    {
        // Delete the associated image if it exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        // Delete the event
        $event->delete();
        
        return redirect()->route('events.index')->with('danger', 'Event deleted successfully!');
    }

    // Display all events to the user (for public view or similar purpose)
    public function showAllEvents()
    {
        $events  = Event::orderBy('created_at', 'desc')->get();
        return view('events.display', compact('events'));
    }
}
