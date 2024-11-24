<?php

namespace App\Http\Controllers;

use App\Models\Slide;

class GuestController extends Controller
{
    public function home()
    {
        $slides = Slide::all(); // Fetch all slides from the database
        return view('home', compact('slides'));
    }
}
