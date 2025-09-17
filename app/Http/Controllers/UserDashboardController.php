<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Import Auth facade
use App\Models\Notification; // Import Notification model
use App\Models\Activity; // Import Activity model
use App\Models\User;

class UserDashboardController extends Controller
{
   // app/Http/Controllers/UserDashboardController.php
public function index()
{
    $user = Auth::user(); // Assuming Auth is properly configured
    $notifications = $user->notifications()->latest()->take(5)->get();
    // $recentActivities = Activity::where('USER_ID', $user->ID)->latest()->take(5)->get();
    

    return view('dashboard.index', compact('user', 'notifications'));
}
        public function edit($id)
        {
            $user = User::findOrFail($id);
            return view('profile.edit', compact('user'));
        }
        public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);
            
            $request->validate([
                'FIRST_NAME' => 'required|string|max:255',
                'LAST_NAME' => 'required|string|max:255',
                'MIDDLE_NAME' => 'nullable|string|max:255',
                'EMAIL' => 'required|email|max:255|unique:users,EMAIL,' . $id . ',ID',
                'NATIONAL_ID_NUMBER' => 'required|string|max:20|unique:users,NATIONAL_ID_NUMBER,' . $id . ',ID',
                'PHONE_NUMBER' => 'required|string|max:15|unique:users,PHONE_NUMBER,' . $id . ',ID',
                'GENDER' => 'required|string|in:Male,Female',
                'DISABILITY_STATUS' => 'required|string|in:Yes,No',
                'DISABILITY_TYPE' => 'nullable|string|max:255',
                // 'CURRENTLY_IN_SCHOOL' => 'required|string|in:Yes,No',
                'POSTAL_ADDRESS' => 'nullable|string|max:255',
                'PHYSICAL_ADDRESS' => 'nullable|string|max:255',
                'LINKEDIN' => 'nullable|string|max:255',
                'DATE' => 'nullable|date',
                'COUNTY' => 'nullable|string|max:255',
                'TITTLE' => 'nullable|string|max:255',
                'HIGHEST_LEVEL_SCHOOL_ATTENDING' => 'nullable|string|in:TVET College,University',
                'SCHOOL_NAME' => 'nullable|string|max:255',
                'PROGRAM_OF_STUDY' => 'nullable|string|max:255',
                'SCHOOL_REGISTRATION_NUMBER' => 'nullable|string|max:255',
                'PREVIOUS_SCHOOL_NAME' => 'nullable|string|max:255',
                'PREVIOUS_PROGRAM_OF_STUDY' => 'nullable|string|max:255',
                'EDUCATION_LEVEL' => 'nullable|string|in:Undergraduate Degree,Post Graduate Diploma,Masters Degree,PhD',
                'PASSPORT_PHOTO' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        
            $user->FIRST_NAME = $request->FIRST_NAME;
            $user->LAST_NAME = $request->LAST_NAME;
            $user->MIDDLE_NAME = $request->MIDDLE_NAME;
            $user->POSTAL_ADDRESS = $request->POSTAL_ADDRESS;
            $user->PHYSICAL_ADDRESS = $request->PHYSICAL_ADDRESS;
            $user->LINKEDIN = $request->LINKEDIN;
            $user->COUNTY = $request->COUNTY;
            $user->EMAIL = $request->EMAIL;
            $user->SCHOOL_NAME = $request->SCHOOL_NAME;
            $user->SCHOOL_REGISTRATION_NUMBER = $request->SCHOOL_REGISTRATION_NUMBER;
            $user->NATIONAL_ID_NUMBER = $request->NATIONAL_ID_NUMBER;
            $user->PHONE_NUMBER = $request->PHONE_NUMBER;
            $user->GENDER = $request->GENDER;
            $user->TITTLE = $request->TITTLE;
            $user->DATE = $request->DATE;
            $user->PROGRAM_OF_STUDY = $request->PROGRAM_OF_STUDY;
            $user->DISABILITY_STATUS = $request->DISABILITY_STATUS;
            $user->DISABILITY_TYPE = $request->DISABILITY_STATUS == 'Yes' ? $request->DISABILITY_TYPE : null;
            // $user->CURRENTLY_IN_SCHOOL = $request->CURRENTLY_IN_SCHOOL;
        
            if ($request->CURRENTLY_IN_SCHOOL == 'Yes') {
                $user->HIGHEST_LEVEL_SCHOOL_ATTENDING = $request->HIGHEST_LEVEL_SCHOOL_ATTENDING;
                $user->SCHOOL_NAME = $request->SCHOOL_NAME;
                $user->PROGRAM_OF_STUDY = $request->PROGRAM_OF_STUDY;
                $user->SCHOOL_REGISTRATION_NUMBER = $request->SCHOOL_REGISTRATION_NUMBER;
            } else {
                $user->PREVIOUS_SCHOOL_NAME = $request->PREVIOUS_SCHOOL_NAME;
                $user->PREVIOUS_PROGRAM_OF_STUDY = $request->PREVIOUS_PROGRAM_OF_STUDY;
                $user->EDUCATION_LEVEL = $request->EDUCATION_LEVEL;
            }
        
            // Handle profile picture update
            if ($request->hasFile('PASSPORT_PHOTO')) {
                $file = $request->file('PASSPORT_PHOTO');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                
                // Move the file directly to the public/profile_photos/ directory
                $file->move(public_path('profile_photos'), $filename);
            
                // Store the relative path in the database
                $user->PASSPORT_PHOTO = 'profile_photos/' . $filename;
            }
          
        
            $user->save();
        
            return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
        }

}
