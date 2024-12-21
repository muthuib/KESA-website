<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\Newsletter;
use App\Models\Collaboration;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch dynamic data
        $totalUsers = User::count();
        $totalResources = Resource::count();
        $totalNewsletters = Newsletter::count();
        $totalCollaborators = Collaboration::count();

        // Simulated growth data for charts
        $growthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        $growthData = [10, 20, 40, 80, 100]; // Replace with real data logic

        // Resource data for charts
        $resourceLabels = ['PDFs', 'Videos', 'Articles'];
        $resourceData = [15, 25, 10]; // Replace with real data logic

        // Pass data to the view
        return view('dashboard.dashboard', compact(
            'totalUsers',
            'totalResources',
            'totalNewsletters',
            'totalCollaborators',
            'growthLabels',
            'growthData',
            'resourceLabels',
            'resourceData'
        ));
    }
}

