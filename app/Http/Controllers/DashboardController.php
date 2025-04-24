<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\Newsletter;
use App\Models\Collaboration;
use App\Models\Membership;
use App\Models\Publication;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalUsers = User::count();
        $totalResources = Resource::count();
        $totalNewsletters = Newsletter::count();
        $totalCollaborators = Collaboration::count();
        $totalMembers = Membership::count();
        $totalPublications = Publication::count(); // Total publications

        // Get the monthly totals for users, publications, etc.
        $monthlyUserCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        
        $monthlyPublicationCounts = Publication::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Calculate growth rates for users and publications (can be expanded for other cards)
        $growthRates = [];
        $growthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // Initialize growth rates with 0 for each month
        $growthRates['users'] = array_fill(0, 12, 0);
        $growthRates['publications'] = array_fill(0, 12, 0);

        foreach ($monthlyUserCounts as $month => $count) {
            if ($month > 1) {
                // Calculate the growth rate for users for each month (starting from the second month)
                $previousMonthCount = $monthlyUserCounts[$month - 1] ?? 0;
                $growthRates['users'][$month - 1] = $previousMonthCount > 0 ? round((($count - $previousMonthCount) / $previousMonthCount) * 100, 2) : 0;
            }
        }

        foreach ($monthlyPublicationCounts as $month => $count) {
            if ($month > 1) {
                // Calculate the growth rate for publications for each month (starting from the second month)
                $previousMonthCount = $monthlyPublicationCounts[$month - 1] ?? 0;
                $growthRates['publications'][$month - 1] = $previousMonthCount > 0 ? round((($count - $previousMonthCount) / $previousMonthCount) * 100, 2) : 0;
            }
        }

        return view('dashboard.dashboard', compact(
            'totalUsers',
            'totalResources',
            'totalNewsletters',
            'totalCollaborators',
            'totalMembers',
            'totalPublications',
            'growthLabels',
            'growthRates'
        ));
    }
}
