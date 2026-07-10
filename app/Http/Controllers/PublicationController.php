<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::latest()->get();
        return view('publications.index', compact('publications'));
    }

public function display($slug = null)
    {
        $publications = Publication::latest()->get();
        $id = null;
        $publication = null;

        if ($slug) {
            $publication = Publication::where('slug', $slug)->first();
            if ($publication) {
                $id = $publication->id;
            }
        }

        return view('publications.display', compact('publications', 'id', 'publication'));
    }


    public function create()
    {
        return view('publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'authors'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,txt|max:10000',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // validation for cover image (max 5MB)
        ]);

        // ✅ Handle main publication file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'publications/' . $fileName;

            $fileSize = $file->getSize();
            $file->move(public_path('publications/'), $fileName);

            $validated['file_path'] = $filePath;
            $validated['file_size'] = $fileSize;
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }

        // ✅ Handle cover image upload (optional)
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_' . $cover->getClientOriginalName();
            $coverPath = 'publication_cover/' . $coverName;

            $cover->move(public_path('publication_cover/'), $coverName);

            $validated['cover_image'] = $coverPath; // Save path in DB
        }

        // ✅ Default values
        $validated['downloads'] = 0;

        // ✅ Generate slug
        $slug = \Illuminate\Support\Str::slug($validated['title']);
        $count = \App\Models\Publication::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $validated['slug'] = $slug;

        \App\Models\Publication::create($validated);

        return redirect()->route('publications.index')->with('success', 'Publication uploaded successfully.');
    }


    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication)
    {
        return view('publications.edit', compact('publication'));
    }

public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'authors'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'sometimes|file|mimes:pdf,doc,docx,txt|max:10000',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // Cover image validation
        ]);

        // ✅ Handle new publication file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'publications/' . $filename;

            $validated['file_size'] = $file->getSize();
            $file->move(public_path('publications'), $filename);

            // 🔥 Delete old file if it exists
            if (!empty($publication->file_path) && file_exists(public_path($publication->file_path))) {
                unlink(public_path($publication->file_path));
            }

            $validated['file_path'] = $filePath;
        } else {
            $validated['file_path'] = $publication->file_path;
            $validated['file_size'] = $publication->file_size;
        }

        // ✅ Handle cover image upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_' . $cover->getClientOriginalName();
            $coverPath = 'publication_cover/' . $coverName;

            $cover->move(public_path('publication_cover/'), $coverName);

            // 🔥 Delete old cover if it exists
            if (!empty($publication->cover_image) && file_exists(public_path($publication->cover_image))) {
                unlink(public_path($publication->cover_image));
            }

            $validated['cover_image'] = $coverPath;
        } else {
            $validated['cover_image'] = $publication->cover_image;
        }

        // ✅ Regenerate slug if title has changed
        if ($validated['title'] !== $publication->title) {
            $slug = \Illuminate\Support\Str::slug($validated['title']);

            // Ensure slug uniqueness
            $count = \App\Models\Publication::where('slug', 'like', "{$slug}%")
                ->where('id', '!=', $publication->id)
                ->count();

            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $validated['slug'] = $slug;
        } else {
            $validated['slug'] = $publication->slug;
        }

        // ✅ Update record
        $publication->update($validated);

        return redirect()->route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication)
    {
        // Delete the file
        if (File::exists(public_path($publication->file_path))) {
            File::delete(public_path($publication->file_path));
        }

        $publication->delete();
        return redirect()->route('publications.index')->with('danger', 'Publication deleted successfully.');
    }

    
    public function download($id)
    {
        $publication = Publication::findOrFail($id);
        $file = public_path($publication->file_path);

        if (!file_exists($file)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $publication->increment('downloads');

        return response()->download($file, $publication->title . '.' . pathinfo($file, PATHINFO_EXTENSION));
    }
    
    // remove/delete cover page
    public function deleteCover($id)
    {
        $publication = Publication::findOrFail($id);

        if ($publication->cover_image && file_exists(public_path($publication->cover_image))) {
            unlink(public_path($publication->cover_image));
        }

        $publication->cover_image = null;
        $publication->save();

        return redirect()->back()->with('danger', 'Cover image removed successfully.');
    }
   public function statistics(Request $request)
    {
        $search = $request->input('search');
        $period = $request->input('period', 'all');

        $publicationsQuery = Publication::query();

        if ($search) {
            $publicationsQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('authors', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
        }

        // Apply period filter to the publications query
        $this->applyPeriodFilter($publicationsQuery, $period);

        $publications = $publicationsQuery->orderBy('downloads', 'desc')->paginate(15);

        $today = Carbon::today();
        $stats = [];
        
        // Get overall stats with period filter applied
        $overallStats = $this->getPublicationOverallStats($period, $today);
        
        // Get most downloaded with period filter
        $mostDownloaded = $this->getMostDownloaded($period, $today);
        
        // Get least downloaded with period filter
        $leastDownloaded = $this->getLeastDownloaded($period, $today);
        
        // Get recent publications with period filter
        $recentPublications = $this->getRecentPublications($period, $today);

        // Calculate stats for each publication in the paginated results
        foreach ($publications as $pub) {
            $stats[$pub->id] = [
                'total_downloads' => $pub->downloads ?? 0,
                'file_size' => $pub->file_size ?? 0,
                'created_at' => $pub->created_at,
            ];
        }

        $overallStats['most_downloaded'] = $mostDownloaded;
        $overallStats['least_downloaded'] = $leastDownloaded;
        $overallStats['recent_publications'] = $recentPublications;

        return view('publications.statistics', compact(
            'publications',
            'stats',
            'overallStats',
            'period',
            'search'
        ));
    }

    /**
     * Apply period filter to a query
     */
    private function applyPeriodFilter($query, $period)
    {
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereDate('created_at', '>=', Carbon::today()->subDays(6));
                break;
            case 'month':
                $query->whereDate('created_at', '>=', Carbon::today()->subDays(29));
                break;
            case 'year':
                $query->whereDate('created_at', '>=', Carbon::today()->subDays(364));
                break;
            case 'all':
            default:
                // No date filter - all time
                break;
        }
    }

    /**
     * Get overall statistics with period filter
     */
    private function getPublicationOverallStats($period, $today)
    {
        $query = Publication::query();
        $this->applyPeriodFilter($query, $period);
        
        $publications = $query->get();
        
        $totalPublications = $publications->count();
        $publicationsWithDownloads = $publications->where('downloads', '>', 0)->count();
        $totalDownloads = $publications->sum('downloads');
        $averageDownloads = $publicationsWithDownloads > 0 ? round($totalDownloads / $publicationsWithDownloads, 1) : 0;
        
        return [
            'total_publications' => $totalPublications,
            'publications_with_downloads' => $publicationsWithDownloads,
            'total_downloads' => $totalDownloads,
            'average_downloads' => $averageDownloads,
        ];
    }

    /**
     * Get most downloaded publication with period filter
     */
    private function getMostDownloaded($period, $today)
    {
        $query = Publication::query();
        $this->applyPeriodFilter($query, $period);
        return $query->orderBy('downloads', 'desc')->first();
    }

    /**
     * Get least downloaded publication with period filter
     */
    private function getLeastDownloaded($period, $today)
    {
        $query = Publication::query();
        $this->applyPeriodFilter($query, $period);
        return $query->where('downloads', '>', 0)->orderBy('downloads', 'asc')->first();
    }

    /**
     * Get recent publications with period filter
     */
    private function getRecentPublications($period, $today)
    {
        $query = Publication::query();
        $this->applyPeriodFilter($query, $period);
        return $query->orderBy('created_at', 'desc')->limit(5)->get();
    }
}
