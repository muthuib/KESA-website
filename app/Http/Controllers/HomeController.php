<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Collaboration;
use App\Models\Feedback;
use App\Http\Controllers\CollaboratorsController;



class HomeController extends Controller
{

//Pass slides to the home view
public function index()
    {
        $slides = Slide::all(); // Fetch all slides
        $collaborations = Collaboration::all(); // Fetch all collaborations
        $feedbacks = Feedback::all(); // Fetch feedbacks

        // Pass variables to the view
        return view('home', compact('slides', 'feedbacks', 'collaborations'));
        
    }
    //show data in home view
    // public function showCollaborations()
    // {
    //     $collaborations = Collaboration::all(); // Fetch all collaborations
    //     return view('home', compact('collaborations'));
    // }

}