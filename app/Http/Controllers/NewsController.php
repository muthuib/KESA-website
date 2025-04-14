<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $newsQuery = News::query();

    if ($search) {
        $newsQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        });
    }

    $news = $newsQuery->orderBy('date', 'desc')->paginate(10);

    return view('news.index', compact('news', 'search'));
}


    public function create()
    {
        return view('news.create');
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
            $imagePath = 'news/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('news'), $imagePath);
        }

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'date' => $request->date,
            'image' => $imagePath
        ]);

        return redirect()->route('news.index')->with('success', 'News added successfully!');
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            if ($news->image && File::exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }
            $news->image = 'news/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('news'), $news->image);
        }

        $news->update($request->only('title', 'content', 'date', 'image'));

        return redirect()->route('news.index')->with('success', 'News updated successfully!');
    }
    public function show(News $news)
        {
            return view('news.show', compact('news'));
        }

    public function destroy(News $news)
    {
        if ($news->image && File::exists(public_path($news->image))) {
            File::delete(public_path($news->image));
        }
        $news->delete();
        return redirect()->route('news.index')->with('danger', 'News deleted successfully.');
    }
    public function display(Request $request)
    {
        $search = $request->input('search');
    
        $newsQuery = News::query();
    
        if ($search) {
            $newsQuery->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
        }
    
        $news = $newsQuery->orderBy('date', 'desc')->paginate(6);
    
        return view('news.display', compact('news', 'search'));
    }
    
}

