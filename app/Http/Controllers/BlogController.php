<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
    $blogs = $blogsQuery->orderBy('created_at', 'desc')->paginate(10);

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
            'content' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'ownership_disclaimer' => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'blog/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('blog'), $imagePath);
        }

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'date' => $request->date,
            'author' => $request->author,
            'category' => $request->category,
            'copyright' => $request->copyright,
            'ownership_disclaimer' => $request->ownership_disclaimer,
            'image' => $imagePath
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog post added successfully!');
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit', ['blog' => $blog]);
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'ownership_disclaimer' => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        $data = $request->only([
            'title', 'content', 'date',
            'author', 'category', 'copyright', 'ownership_disclaimer'
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }

            $imageName = 'blog/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('blog'), $imageName);

            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully!');
    }

      public function show($id)
{
    $blog = Blog::findOrFail($id);
    $sessionKey = 'blog_viewed_' . $id;
    $now = now();

    // Check if session exists and if 24 hours have passed
    if (!session()->has($sessionKey) || $now->diffInHours(session($sessionKey)) >= 24) {
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

        $blogs = $blogsQuery->orderBy('created_at', 'desc')->paginate(6);

        return view('blog.display', compact('blogs', 'search'));
    }
}
