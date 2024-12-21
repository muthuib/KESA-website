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
    // Total counts
    $totalUsers = User::count();
    $totalResources = Resource::count();
    $totalNewsletters = Newsletter::count();
    $totalCollaborators = Collaboration::count();

    // Growth data (simulate with months or actual DB data)
    $growthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $growthData = array_fill(0, 12, 0); // Example data, replace with real monthly counts
    foreach (User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->groupBy('month')->pluck('count', 'month') as $month => $count) {
        $growthData[$month - 1] = $count; // Match array indexes (Jan = 0, Feb = 1)
    }

    // Resource data
    $resourceLabels = ['PDFs', 'Videos', 'Articles'];
    $resourceData = [
        Resource::where('TYPE', 'pdf')->count(),
        Resource::where('TYPE', 'video')->count(),
        Resource::where('TYPE', 'article')->count()
    ];

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

