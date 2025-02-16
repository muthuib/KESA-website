<?php

namespace App\Http\Controllers;

use App\Models\LiveEvent;
use Illuminate\Http\Request;

class LiveEventController extends Controller
{
    public function index()
    {
        $events = LiveEvent::orderBy('date_time', 'desc')->get();
        return view('live-events.index', compact('events'));
    }

    public function create()
    {
        return view('live-events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|in:YouTube,Facebook,Zoom,Google Meet,Other',
            'link' => 'required|url|max:500',
            'date_time' => 'required|date',
        ]);

        LiveEvent::create($request->all());

        return redirect()->route('live-events.index')->with('success', 'Live event added successfully!');
    }
    public function list()
    {
        $events = LiveEvent::orderBy('date_time', 'desc')->get();
        return view('live-events.list', compact('events'));
    }
    public function edit($id)
    {
        $event = LiveEvent::findOrFail($id);
        return view('live-events.edit', compact('event'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'platform' => 'required',
            'link' => 'required|url',
            'date_time' => 'required|date',
        ]);
    
        $event = LiveEvent::findOrFail($id);
        $event->update($request->all());
    
        return redirect()->route('live-events.list')->with('success', 'Live event updated successfully.');
    }
    
    public function destroy($id)
    {
        $event = LiveEvent::findOrFail($id);
        $event->delete();
    
        return redirect()->route('live-events.list')->with('danger', 'Live event deleted successfully.');
    }
}

