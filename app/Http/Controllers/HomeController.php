<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;

class HomeController extends Controller
{

//Pass slides to the home view
public function index()
{
    $slides = Slide::all();
    return view('home', compact('slides'));
}
}