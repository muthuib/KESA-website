<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Import Auth facade
use App\Models\Notification; // Import Notification model
use App\Models\Activity; // Import Activity model

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get authenticated user
        $notifications = $user->notifications()->latest()->take(5)->get(); // Fetch recent notifications
        $recentActivities = Activity::where('user_id', $user->id)->latest()->take(5)->get(); // Get recent activities
    
        return view('dashboard.index', compact('user', 'notifications', 'recentActivities'));
    }
}
