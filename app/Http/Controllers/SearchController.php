<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\About;
use App\Models\Contact;
use App\Models\LiveEvent;
use App\Models\Resource;
use App\Models\SocialLink;
use App\Models\TeamMember;
use App\Models\Collaboration;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $searchTerm = $request->input('query'); // Get search term from input

    // Search across multiple models
    $events = Event::where('name', 'like', "%{$searchTerm}%")
        ->orWhere('description', 'like', "%{$searchTerm}%")
        ->get();

    $about = About::where('VISION', 'like', "%{$searchTerm}%")
        ->orWhere('MISSION', 'like', "%{$searchTerm}%")
        ->orWhere('ABOUT', 'like', "%{$searchTerm}%")
        ->get();

    $contacts = Contact::where('organization_name', 'like', "%{$searchTerm}%")
        ->orWhere('email', 'like', "%{$searchTerm}%")
        ->orWhere('phone', 'like', "%{$searchTerm}%")
        ->get();

    // Combine all results into an array
    $results = collect([$events, $about, $contacts])->flatten(); 

    return view('search.results', compact('results', 'searchTerm'));
}
}
