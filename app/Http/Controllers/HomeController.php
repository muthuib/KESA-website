<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Collaboration;
use App\Models\Feedback;
use App\Models\Impact;
use App\Http\Controllers\CollaboratorsController;



class HomeController extends Controller
{

//Pass slides to the home view
public function index()
{
    $slides = Slide::all(); 
    $collaborations = Collaboration::all(); 
    $feedbacks = Feedback::all(); 
    $impact = Impact::first(); // 👈 This is what was missing

    return view('home', compact('slides', 'feedbacks', 'collaborations', 'impact'));
}

    //show data in home view
    // public function showCollaborations()
    // {
    //     $collaborations = Collaboration::all(); // Fetch all collaborations
    //     return view('home', compact('collaborations'));
    // }

}