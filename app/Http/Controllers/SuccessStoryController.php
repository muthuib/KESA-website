<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuccessStoryController extends Controller
{
    /** -------------------------------
     *  Admin: View all success stories
     * -------------------------------- */
    public function index()
    {
        $stories = SuccessStory::latest()->paginate(10);
        return view('success_stories.index', compact('stories'));
    }

    /** -------------------------------
     *  Show create form
     * -------------------------------- */
    public function create()
    {
        return view('success_stories.create');
    }

    /** -------------------------------
     *  Store new story
     * -------------------------------- */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string', // CKEditor HTML content
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'caption'     => 'nullable|string|max:255',
            'author'      => 'nullable|string|max:100',
        ]);

        $data = $request->only(['title', 'body', 'caption', 'author']);
        $data['uuid'] = Str::uuid();
        $data['slug'] = Str::slug($request->title);
        $data['status'] = 'published';
        $data['visibility'] = 'public';
        $data['published_at'] = Carbon::now('Africa/Nairobi');

        // Optional excerpt for meta preview
        $data['excerpt'] = Str::limit(strip_tags($request->body), 150);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $filename = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('success_stories'), $filename);
            $data['cover_image'] = 'success_stories/' . $filename;
        }

        SuccessStory::create($data);

        return redirect()->route('success_stories.index')->with('success', 'Story added successfully!');
    }

    /** -------------------------------
     *  Edit story form
     * -------------------------------- */
    public function edit(SuccessStory $success_story)
    {
        return view('success_stories.edit', compact('success_story'));
    }

    /** -------------------------------
     *  Update story
     * -------------------------------- */
    public function update(Request $request, SuccessStory $success_story)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'caption'     => 'nullable|string|max:255',
            'author'      => 'nullable|string|max:100',
        ]);

        $data = $request->only(['title', 'body', 'caption', 'author']);
        $data['slug'] = Str::slug($request->title);

        // Optional excerpt update
        $data['excerpt'] = Str::limit(strip_tags($request->body), 150);

        // If updating to published, set published_at if missing
        if ($success_story->status !== 'published') {
            $data['published_at'] = Carbon::now('Africa/Nairobi');
        }

        // Handle new cover image upload
        if ($request->hasFile('cover_image')) {
            // Optionally delete old cover image
            if ($success_story->cover_image && file_exists(public_path($success_story->cover_image))) {
                unlink(public_path($success_story->cover_image));
            }

            $filename = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('success_stories'), $filename);
            $data['cover_image'] = 'success_stories/' . $filename;
        }

        $success_story->update($data);

        return redirect()->route('success_stories.index')->with('success', 'Story updated successfully!');
    }

    /** -------------------------------
     *  Delete story
     * -------------------------------- */
    public function destroy(SuccessStory $success_story)
    {
        // Optionally delete cover image
        if ($success_story->cover_image && file_exists(public_path($success_story->cover_image))) {
            unlink(public_path($success_story->cover_image));
        }

        $success_story->delete();
        return redirect()->route('success_stories.index')->with('danger', 'Story deleted successfully!');
    }

    /** -------------------------------
     *  Public: List of stories
     * -------------------------------- */
    public function publicIndex(Request $request)
    {
        $search = $request->input('search');
        $stories = SuccessStory::where('status', 'published')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhere('excerpt', 'like', "%$search%")
                      ->orWhere('author', 'like', "%$search%");
            })
            ->latest('published_at')
            ->paginate(12);

        return view('success_stories.public_index', compact('stories', 'search'));
    }

    /** -------------------------------
     *  Public: Single story view
     * -------------------------------- */
    public function show($slug)
    {
        $story = SuccessStory::where('slug', $slug)->firstOrFail();

        // Fetch 3 related stories (excluding the current one)
        $relatedStories = SuccessStory::where('slug', '!=', $slug)
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('success_stories.show', compact('story', 'relatedStories'));
    }
}
