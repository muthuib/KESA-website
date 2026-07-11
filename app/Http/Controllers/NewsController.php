<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    // ---------------------------------------------------------------
    // INDEX
    // ---------------------------------------------------------------
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

    // ---------------------------------------------------------------
    // CREATE
    // ---------------------------------------------------------------
    public function create()
    {
        return view('news.create');
    }

    // ---------------------------------------------------------------
    // STORE
    // ---------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'content'=> 'required|string',
            'date'   => 'required|date',
            'image'  => 'nullable|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:51200',
            'media1' => 'nullable|image|max:10240',
            'media2' => 'nullable|image|max:10240',
            'media3' => 'nullable|image|max:10240',
        ]);

        // --- Main media (image or video) ---
        $mediaPath = null;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $mediaPath = 'news/' . time() . '_main.' . $file->extension();
            $file->move(public_path('news'), $mediaPath);
        }

        // --- Additional images ---
        $media1Path = $this->uploadAdditionalImage($request, 'media1', 'img1');
        $media2Path = $this->uploadAdditionalImage($request, 'media2', 'img2');
        $media3Path = $this->uploadAdditionalImage($request, 'media3', 'img3');

        News::create([
            'title'   => $request->title,
            'content' => $request->content,
            'date'    => $request->date,
            'image'   => $mediaPath,   // main media stored in 'image' column
            'media1'  => $media1Path,
            'media2'  => $media2Path,
            'media3'  => $media3Path,
            'views'   => 0,
        ]);

        return redirect()->route('news.index')->with('success', 'News added successfully!');
    }

    // ---------------------------------------------------------------
    // EDIT
    // ---------------------------------------------------------------
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    // ---------------------------------------------------------------
    // UPDATE
    // ---------------------------------------------------------------
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'content'=> 'required|string',
            'date'   => 'required|date',
            'media'  => 'nullable|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:51200',
            'media1' => 'nullable|image|max:10240',
            'media2' => 'nullable|image|max:10240',
            'media3' => 'nullable|image|max:10240',
        ]);

        $data = $request->only('title', 'content', 'date');

        // --- Main media ---
        if ($request->hasFile('media')) {
            $this->deleteFile($news->image);

            $file          = $request->file('media');
            $mediaPath     = 'news/' . time() . '_main.' . $file->extension();
            $file->move(public_path('news'), $mediaPath);
            $data['image'] = $mediaPath;
        }

        // --- Additional image 1 ---
        if ($request->hasFile('media1')) {
            $this->deleteFile($news->media1);
            $data['media1'] = $this->uploadAdditionalImage($request, 'media1', 'img1');
        }

        // --- Additional image 2 ---
        if ($request->hasFile('media2')) {
            $this->deleteFile($news->media2);
            $data['media2'] = $this->uploadAdditionalImage($request, 'media2', 'img2');
        }

        // --- Additional image 3 ---
        if ($request->hasFile('media3')) {
            $this->deleteFile($news->media3);
            $data['media3'] = $this->uploadAdditionalImage($request, 'media3', 'img3');
        }

        $news->update($data);

        return redirect()->route('news.index')->with('success', 'News updated successfully!');
    }

    // ---------------------------------------------------------------
    // SHOW
    // ---------------------------------------------------------------
    public function show($id)
    {
        $news       = News::findOrFail($id);
        $sessionKey = 'viewed_news_' . $id;

        if (!session()->has($sessionKey)) {
            $news->increment('views');
            session()->put($sessionKey, true);
        }

        $otherNews = News::where('id', '!=', $id)
                        ->orderBy('date', 'desc')
                        ->get();

        return view('news.show', compact('news', 'otherNews'));
    }

    // ---------------------------------------------------------------
    // DESTROY
    // ---------------------------------------------------------------
    public function destroy(News $news)
    {
        // Delete all associated files
        $this->deleteFile($news->image);
        $this->deleteFile($news->media1);
        $this->deleteFile($news->media2);
        $this->deleteFile($news->media3);

        $news->delete();

        return redirect()->route('news.index')->with('danger', 'News deleted successfully.');
    }

    // ---------------------------------------------------------------
    // DISPLAY (public-facing)
    // ---------------------------------------------------------------
    public function display(Request $request)
    {
        $search    = $request->input('search');
        $newsQuery = News::query();

        if ($search) {
            $newsQuery->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
        }

        $news = $newsQuery->orderBy('date', 'desc')->paginate(6);

        return view('news.display', compact('news', 'search'));
    }

    // ===============================================================
    // PRIVATE HELPERS
    // ===============================================================

    /**
     * Upload a single additional image and return its stored path.
     */
    private function uploadAdditionalImage(Request $request, string $inputName, string $suffix): ?string
    {
        if (!$request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);
        $path = 'news/' . time() . "_{$suffix}." . $file->extension();
        $file->move(public_path('news'), $path);

        return $path;
    }

    /**
     * Delete a file from the public directory if it exists.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
