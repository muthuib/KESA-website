<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Import Auth facade
use App\Models\Notification; // Import Notification model
use App\Models\Activity; // Import Activity model

class UserDashboardController extends Controller
{
   // app/Http/Controllers/UserDashboardController.php
public function index()
{
    $user = Auth::user(); // Assuming Auth is properly configured
    $notifications = $user->notifications()->latest()->take(5)->get();
    $recentActivities = Activity::where('USER_ID', $user->ID)->latest()->take(5)->get();
    

    return view('dashboard.index', compact('user', 'notifications', 'recentActivities'));
}

}
