<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;


class BlogController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $blogsQuery = Blog::query();

    if ($search) {
        $blogsQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        });
    }

    // Paginate blogs (once)
    $blogs = $blogsQuery->orderBy('date', 'desc')->paginate(10);

    // Initialize stats array
    $today = Carbon::today();
    $stats = [];

    foreach ($blogs as $blog) {
        $stats[$blog->id] = [
            'last_1_day' => DB::table('blog_view_logs')
                ->where('blog_id', $blog->id)
                ->where('view_date', $today)
                ->sum('views'),

            'last_7_days' => DB::table('blog_view_logs')
                ->where('blog_id', $blog->id)
                ->where('view_date', '>=', $today->copy()->subDays(6))
                ->sum('views'),

            'last_30_days' => DB::table('blog_view_logs')
                ->where('blog_id', $blog->id)
                ->where('view_date', '>=', $today->copy()->subDays(29))
                ->sum('views'),

            'last_365_days' => DB::table('blog_view_logs')
                ->where('blog_id', $blog->id)
                ->where('view_date', '>=', $today->copy()->subDays(364))
                ->sum('views'),
        ];
    }

    // Return view with blogs, stats, and search
    return view('blog.index', compact('blogs', 'search', 'stats'));
}

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
     $request->validate([
            'title' => 'required|string',
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'ownership_disclaimer' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg|max:2048',
        ],
    [
    'image.max' => 'The image size should not exceed 2MB.',
    'image.mimes' => 'Only JPG/JPEG images are allowed.',
   ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'blog/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('blog'), $imagePath);
        }

        try {
                Blog::create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title), // ✅ generate slug
                    'name' => $request->name,
                    'content' => $request->content,
                    'date' => $request->date,
                    'author' => $request->author,
                    'category' => $request->category,
                    'copyright' => $request->copyright,
                    'ownership_disclaimer' => $request->ownership_disclaimer,
                    'image' => $imagePath
                ]);

                return redirect()->route('blog.index')->with('success', 'Blog post added successfully!');
            } catch (QueryException $e) {
                if ($e->errorInfo[1] == 1062) { // Duplicate entry
                    return back()->withInput()->withErrors(['title' => 'A blog with this title already exists. Please use a different title.']);
                }
                throw $e; // rethrow if it's another error
            }
        }

    public function edit(Blog $blog)
    {
        return view('blog.edit', ['blog' => $blog]);
    }

   public function update(Request $request, Blog $blog)
        {
            $request->validate([
                'title' => 'required|string',
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'date' => 'required|date',
                'author' => 'required|string|max:255',
                'category' => 'nullable|string|max:255',
                'copyright' => 'nullable|string|max:255',
                'ownership_disclaimer' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
            ], [
                'image.max' => 'The image size should not exceed 2MB.',
                'image.mimes' => 'Only JPG/JPEG images are allowed.',
            ]);

            $data = $request->only([
                'title', 'name', 'content', 'date',
                'author', 'category', 'copyright', 'ownership_disclaimer'
            ]);

            // ✅ generate slug
            $data['slug'] = Str::slug($request->title);

            if ($request->hasFile('image')) {
                if ($blog->image && File::exists(public_path($blog->image))) {
                    File::delete(public_path($blog->image));
                }

                $imageName = 'blog/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('blog'), $imageName);

                $data['image'] = $imageName;
            }

               try {
                    $blog->update($data);
                    return redirect()->route('blog.index')->with('success', 'Blog post updated successfully!');
                } catch (QueryException $e) {
                    if ($e->errorInfo[1] == 1062) { // Duplicate entry
                        return back()->withInput()->withErrors(['title' => 'A blog with this title already exists. Please change it.']);
                    }
                    throw $e;
                }
        }

     public function show($slug)
{
    $blog = Blog::where('slug', $slug)->firstOrFail();
    $id = $blog->id; // keep id for stats tracking
    $sessionKey = 'blog_viewed_' . $id;
    $now = now();

    // Check if session exists and if 24 hours have passed
    if (!session()->has($sessionKey) || $now->diffInHours(session($sessionKey)) >= 2) {
        $blog->increment('views');
        session()->put($sessionKey, $now);

        // Log view
        DB::table('blog_view_logs')->updateOrInsert(
            [
                'blog_id' => $id,
                'view_date' => $now->toDateString(),
            ],
            [
                'views' => DB::raw('views + 1'),
                'updated_at' => $now,
            ]
        );
    }

    // Get stats
    $today = Carbon::today();
    $stats = [
        'last_1_day' => DB::table('blog_view_logs')
            ->where('blog_id', $id)
            ->where('view_date', $today)
            ->sum('views'),

        'last_7_days' => DB::table('blog_view_logs')
            ->where('blog_id', $id)
            ->where('view_date', '>=', $today->copy()->subDays(6))
            ->sum('views'),

        'last_30_days' => DB::table('blog_view_logs')
            ->where('blog_id', $id)
            ->where('view_date', '>=', $today->copy()->subDays(29))
            ->sum('views'),

        'last_365_days' => DB::table('blog_view_logs')
            ->where('blog_id', $id)
            ->where('view_date', '>=', $today->copy()->subDays(364))
            ->sum('views'),
    ];

    $otherBlogs = Blog::where('id', '!=', $id)
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

    return view('blog.show', compact('blog', 'otherBlogs', 'stats'));
}



    public function destroy(Blog $blog)
    {
        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }
        $blog->delete();

        return redirect()->route('blog.index')->with('danger', 'Blog post deleted successfully.');
    }

    public function display(Request $request)
    {
        $search = $request->input('search');

        $blogsQuery = Blog::query();

        if ($search) {
            $blogsQuery->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
        }

        $blogs = $blogsQuery->orderBy('date', 'desc')->paginate(6);

        return view('blog.display', compact('blogs', 'search'));
    }

   public function byAuthor($author)
    {
        $blogs = Blog::where('author', 'LIKE', "%{$author}%")
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('blog.by-author', compact('blogs', 'author'));
    }
     public function statistics(Request $request)
    {
        $search = $request->input('search');
        $period = $request->input('period', 'all');
        
        $blogsQuery = Blog::query();
        
        if ($search) {
            $blogsQuery->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
        }
        
        // Get all blogs first for the stats
        $blogs = $blogsQuery->orderBy('views', 'desc')->paginate(15);
        
        $today = Carbon::today();
        $stats = [];
        $totalViews = 0;
        
        // Calculate stats for each blog based on the period
        foreach ($blogs as $blog) {
            $stats[$blog->id] = $this->getBlogStats($blog->id, $period, $today);
        }
        
        // Overall statistics - these should reflect the period filter
        $overallStats = $this->getOverallStats($period, $today);
        
        // Monthly trends - should reflect the period filter
        $monthlyTrends = $this->getMonthlyTrends($period, $today);
        
        // Top categories - should reflect the period filter
        $topCategories = $this->getTopCategories($period, $today);
        
        // Top authors - should reflect the period filter
        $topAuthors = $this->getTopAuthors($period, $today);
        
        return view('blog.statistics', compact(
            'blogs',
            'stats',
            'overallStats',
            'monthlyTrends',
            'topCategories',
            'topAuthors',
            'period',
            'search'
        ));
    }
    
    private function getBlogStats($blogId, $period, $today)
    {
        $query = DB::table('blog_view_logs')->where('blog_id', $blogId);
        
        // Apply period filter
        $this->applyPeriodFilter($query, $period, $today);
        
        $totalViews = $query->sum('views');
        $uniqueViews = $query->count();
        $lastViewed = $query->orderBy('view_date', 'desc')->value('view_date');
        
        // Get daily, weekly, monthly views with period filter
        $dailyQuery = DB::table('blog_view_logs')->where('blog_id', $blogId)->where('view_date', $today);
        $this->applyPeriodFilter($dailyQuery, $period, $today);
        
        $weeklyQuery = DB::table('blog_view_logs')->where('blog_id', $blogId)->where('view_date', '>=', $today->copy()->subDays(6));
        $this->applyPeriodFilter($weeklyQuery, $period, $today);
        
        $monthlyQuery = DB::table('blog_view_logs')->where('blog_id', $blogId)->where('view_date', '>=', $today->copy()->subDays(29));
        $this->applyPeriodFilter($monthlyQuery, $period, $today);
        
        return [
            'total_views' => $totalViews,
            'unique_views' => $uniqueViews,
            'daily_views' => $dailyQuery->sum('views'),
            'weekly_views' => $weeklyQuery->sum('views'),
            'monthly_views' => $monthlyQuery->sum('views'),
            'last_viewed' => $lastViewed,
        ];
    }
    
    private function getOverallStats($period, $today)
    {
        // Total views
        $totalViewsQuery = DB::table('blog_view_logs');
        $this->applyPeriodFilter($totalViewsQuery, $period, $today);
        $totalViews = $totalViewsQuery->sum('views');
        
        // Views in last 7 days
        $viewsLast7DaysQuery = DB::table('blog_view_logs')->where('view_date', '>=', $today->copy()->subDays(6));
        $this->applyPeriodFilter($viewsLast7DaysQuery, $period, $today);
        $viewsLast7Days = $viewsLast7DaysQuery->sum('views');
        
        // Views in last 30 days
        $viewsLast30DaysQuery = DB::table('blog_view_logs')->where('view_date', '>=', $today->copy()->subDays(29));
        $this->applyPeriodFilter($viewsLast30DaysQuery, $period, $today);
        $viewsLast30Days = $viewsLast30DaysQuery->sum('views');
        
        // Count blogs with views
        $blogsWithViews = DB::table('blog_view_logs')
            ->select('blog_id')
            ->distinct();
        $this->applyPeriodFilter($blogsWithViews, $period, $today);
        $blogsWithViewsCount = $blogsWithViews->count();
        
        return [
            'total_blogs' => Blog::count(),
            'blogs_with_views' => $blogsWithViewsCount,
            'total_views' => $totalViews,
            'views_last_7_days' => $viewsLast7Days,
            'views_last_30_days' => $viewsLast30Days,
            'average_views' => $blogsWithViewsCount > 0 ? round($totalViews / $blogsWithViewsCount, 1) : 0,
        ];
    }
    
    private function getMonthlyTrends($period, $today)
    {
        $query = DB::table('blog_view_logs')
            ->select(
                DB::raw('YEAR(view_date) as year'),
                DB::raw('MONTH(view_date) as month'),
                DB::raw('SUM(views) as total_views')
            )
            ->groupBy(DB::raw('YEAR(view_date)'), DB::raw('MONTH(view_date)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');
        
        $this->applyPeriodFilter($query, $period, $today);
        
        return $query->get();
    }
    
    private function getTopCategories($period, $today)
    {
        $query = Blog::select('category', DB::raw('SUM(views) as total_views'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('total_views', 'desc')
            ->limit(10);
        
        // If period is not 'all', we need to filter blogs that have views in this period
        if ($period !== 'all') {
            $blogIdsWithViews = DB::table('blog_view_logs')
                ->select('blog_id')
                ->distinct();
            $this->applyPeriodFilter($blogIdsWithViews, $period, $today);
            $blogIds = $blogIdsWithViews->pluck('blog_id')->toArray();
            
            if (!empty($blogIds)) {
                $query->whereIn('id', $blogIds);
            } else {
                return collect([]);
            }
        }
        
        return $query->get();
    }
    
    private function getTopAuthors($period, $today)
    {
        $query = Blog::select('author', DB::raw('SUM(views) as total_views'))
            ->whereNotNull('author')
            ->groupBy('author')
            ->orderBy('total_views', 'desc')
            ->limit(10);
        
        if ($period !== 'all') {
            $blogIdsWithViews = DB::table('blog_view_logs')
                ->select('blog_id')
                ->distinct();
            $this->applyPeriodFilter($blogIdsWithViews, $period, $today);
            $blogIds = $blogIdsWithViews->pluck('blog_id')->toArray();
            
            if (!empty($blogIds)) {
                $query->whereIn('id', $blogIds);
            } else {
                return collect([]);
            }
        }
        
        return $query->get();
    }
    
    private function applyPeriodFilter($query, $period, $today)
    {
        switch ($period) {
            case 'today':
                $query->where('view_date', $today);
                break;
            case 'week':
                $query->where('view_date', '>=', $today->copy()->subDays(6));
                break;
            case 'month':
                $query->where('view_date', '>=', $today->copy()->subDays(29));
                break;
            case 'year':
                $query->where('view_date', '>=', $today->copy()->subDays(364));
                break;
            case 'all':
            default:
                // No date filter - all time
                break;
        }
    }

}
