<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    // Public view for users
public function index(Request $request)
    {
        // Capture optional search filters
        $search = $request->input('search');
        $location = $request->input('location');
        $department = $request->input('department');

        $today = \Carbon\Carbon::today();

        // Step 1: Auto-close jobs whose deadline passed more than 1 day ago
        \App\Models\Career::where('status', 'Open')
            ->where('deadline', '<', $today->copy()->subDay()->startOfDay()) // deadline < yesterday
            ->update(['status' => 'Closed']);

        // Step 2: Fetch active jobs (still open + grace period of 1 day)
        $careers = \App\Models\Career::where('status', 'Open')
            ->where('deadline', '>=', $today->copy()->subDay()->startOfDay()) // show yesterday & later
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($location, fn($q) => $q->where('location', 'like', "%{$location}%"))
            ->when($department, fn($q) => $q->where('department', 'like', "%{$department}%"))
            ->orderBy('deadline', 'desc')
            ->paginate(6);

        return view('careers.index', compact('careers', 'search', 'location', 'department'));
    }

    // Admin: create job
    public function store(Request $request)
        {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'department' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'job_type' => 'required|string',
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                'salary_range' => 'nullable|string|max:100',
                'deadline' => 'required|date',
                'status' => 'required|string',
            ]);

            Career::create($data);
            return back()->with('success', 'Career opportunity Added successfully.');
        }
            /**
         * Display the specified career details.
         */
        public function show($id)
        {
            $career = Career::find($id);

            if (!$career) {
                return redirect()
                    ->route('admin.careers.index')
                    ->with('error', 'Career not found.');
            }

            return view('admin.careers.show', compact('career'));
        }

        /**
         * Show the form for editing a career.
         */
        public function edit($id)
        {
            $career = Career::find($id);

            if (!$career) {
                return redirect()
                    ->route('admin.careers.index')
                    ->with('error', 'Career not found.');
            }

            return view('admin.careers.edit', compact('career'));
        }

        /**
         * Update the specified career.
         */
       public function update(Request $request, $id)
        {
            $career = Career::find($id);

            if (!$career) {
                return redirect()
                    ->route('admin.careers.index')
                    ->with('error', 'Career not found.');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'deadline' => 'required|date',
                'description' => 'required|string',
            ]);

            // 🕒 Determine status automatically
            $deadline = \Carbon\Carbon::parse($validated['deadline']);
            $today = \Carbon\Carbon::today();

            if ($deadline->isPast() && !$deadline->isToday()) {
                $validated['status'] = 'Closed';
            } else {
                $validated['status'] = 'Open';
            }

            // 💾 Update the record
            $career->update($validated);

            return redirect()
                ->route('admin.careers.index')
                ->with('success', 'Career updated successfully.');
        }


        /**
         * Remove the specified career.
         */
        public function destroy($id)
        {
            $career = Career::find($id);

            if (!$career) {
                return redirect()
                    ->route('admin.careers.index')
                    ->with('error', 'Career not found.');
            }

            $career->delete();

            return redirect()
                ->route('admin.careers.index')
                ->with('danger', 'Career deleted successfully.');
        }

    // User applies for job
       public function apply(Request $request, $careerId)
        {
            // 🔒 Ensure user is logged in
            if (!auth()->check()) {
                return redirect()->route('login')->with('danger', 'Please log in to apply for this job.');
            }

            $career = Career::findOrFail($careerId);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'cover_letter' => 'nullable|string',
                'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('resumes'), $filename);
                $data['resume'] = 'resumes/' . $filename;
            }

            $data['career_id'] = $career->id;
            $data['user_id'] = auth()->id();

            CareerApplication::create($data);

            return back()->with('success', 'Application submitted successfully!');
        }

    // Admin view for all careers
       public function adminIndex()
        {
            // 🕒 Get today's date
            $today = \Carbon\Carbon::today();

            // ✅ Automatically close any job whose deadline has *passed* (before today)
            // but keep jobs with today's date still Open
            \App\Models\Career::where('deadline', '<', $today)
                ->where('status', 'Open')
                ->update(['status' => 'Closed']);

            // 📋 Retrieve all careers (newest first)
            $careers = \App\Models\Career::latest()->paginate(10);

            // 📦 Return to admin view
            return view('admin.careers.index', compact('careers'));
        }

        // View applicants for a specific job
        public function viewApplicants($id)
        {
            $career = Career::with('applications')->findOrFail($id);
            return view('admin.careers.applicants', compact('career'));
        }

        // Update applicant status
        public function updateApplicationStatus(Request $request, $id)
        {
            $application = CareerApplication::findOrFail($id);
            $application->status = $request->status;
            $application->save();

            return back()->with('success', 'Application status updated successfully.');
        }
    //  user tracking his application
    public function myApplications()
    {
        $applications = CareerApplication::with('career')
            ->where('email', auth()->user()->EMAIL)
            ->latest()
            ->get();

        return view('careers.my_applications', compact('applications'));
    }
}
