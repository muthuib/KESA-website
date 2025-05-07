<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // You may rename this model to Blog later
use Illuminate\Support\Facades\File;

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

        $blogs = $blogsQuery->orderBy('date', 'desc')->paginate(10);

        return view('blog.index', compact('blogs', 'search'));
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
            'image' => 'nullable|image'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'blog/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('blog'), $imagePath);
        }

       Blog ::create([
            'title' => $request->title,
            'content' => $request->content,
            'date' => $request->date,
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
            'image' => 'nullable|image'
        ]);

        $data = $request->only('title', 'content', 'date');

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

    public function show(Blog $blog)
    {
        return view('blog.show', ['blog' => $blog]);
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
}
