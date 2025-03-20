<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Display feedback form
    public function create()
    {
        return view('feedback.create');
    }

    // Store feedback
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        Feedback::create($request->all());

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    // Display all feedback
    public function index()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('feedback.index', compact('feedbacks'));
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); // Fetch feedback or throw 404 if not found
        $feedback->delete(); // Delete the feedback from the database
        return redirect()->back()->with('danger', 'Feedback deleted successfully!');
    }
       // Display feedbacks in the view
    public function display()
    {
        $feedbacks = Feedback::latest()->take(10)->get();
       return view('your-view-name', compact('feedbacks'));
        // Return the 'feedback.display' view and pass the feedback data
        return view('feedback.display', compact('feedbacks'));
    }

}

