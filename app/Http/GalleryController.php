<?php

namespace App\Http\Controllers;

use App\Models\GalleryEvent;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Services\Gallery\ImageProcessor;

class GalleryController extends Controller
{
    /**
     * Display all events
     */
    public function index()
    {
        $events = GalleryEvent::with([
                'photos' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->withCount('photos')
            ->where('status', 'Published')
            ->orderByDesc('event_date')
            ->paginate(9);

        return view('gallery.index', compact('events'));
    }

    /**
     * Show upload page by event slug
     */
    // public function uploadPage($slug)
    // {
    //     $event = GalleryEvent::where('slug', $slug)->firstOrFail();
    //     return view('gallery.upload', compact('event'));
    // }
	public function uploadPage($slug)
	{
	    \Log::info('uploadPage received slug: ' . $slug);
	    
	    $event = GalleryEvent::where('slug', $slug)->firstOrFail();
	    
	    \Log::info('Event found: ID=' . $event->id . ', Slug=' . $event->slug);
	    
	    return view('gallery.upload', compact('event'));
	}

    /**
     * Show create event form
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store event
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|max:255',
            'event_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($request->event_name);

            if (GalleryEvent::where('slug', $slug)->exists()) {
                $slug .= '-' . time();
            }

            $event = GalleryEvent::create([
                'uuid' => (string) Str::uuid(),
                'event_name' => $request->event_name,
                'slug' => $slug,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'created_by' => auth()->id(),
                'status' => 'Published',
            ]);

            $folders = ['originals', 'thumbnails', 'small', 'medium', 'large'];

            foreach ($folders as $folder) {
                $path = public_path("gallery/{$slug}/{$folder}");
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
            }

            DB::commit();

            return redirect()
                ->route('gallery.show', $event->slug)
                ->with('success', 'Event created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show event gallery by slug
     */
    public function show($slug)
    {
        $event = GalleryEvent::where('slug', $slug)->firstOrFail();

        $photos = GalleryPhoto::where('event_id', $event->id)
            ->latest()
            ->paginate(24);

        return view('gallery.show', compact('event', 'photos'));
    }

	/**
 * Show the form for editing the event
 */
public function edit($slug)
{
    $event = GalleryEvent::where('slug', $slug)->firstOrFail();
    return view('gallery.edit', compact('event'));
}

/**
 * Update the event
 */
	public function update(Request $request, $slug)
	{
	    $request->validate([
	        'event_name' => 'required|max:255',
	        'event_date' => 'required|date',
	        'description' => 'nullable|string',
	        'location' => 'nullable|string|max:255',
	        'status' => 'nullable|in:Published,Draft'
	    ]);
	
	    $event = GalleryEvent::where('slug', $slug)->firstOrFail();
	
	    DB::beginTransaction();
	
	    try {
	        // Update event details
	        $event->event_name = $request->event_name;
	        $event->description = $request->description;
	        $event->event_date = $request->event_date;
	        $event->location = $request->location;
	        
	        if ($request->has('status')) {
	            $event->status = $request->status;
	        }
	        
	        // If event name changed, update slug
	        if ($event->isDirty('event_name')) {
	            $newSlug = Str::slug($request->event_name);
	            
	            // Ensure uniqueness
	            if (GalleryEvent::where('slug', $newSlug)->where('id', '!=', $event->id)->exists()) {
	                $newSlug = $newSlug . '-' . time();
	            }
	            
	            $event->slug = $newSlug;
	        }
	
	        $event->save();
	
	        DB::commit();
	
	        return redirect()
	            ->route('gallery.show', $event->slug)
	            ->with('success', 'Event updated successfully.');
	
	    } catch (\Exception $e) {
	        DB::rollBack();
	        
	        return back()
	            ->withInput()
	            ->with('error', 'Failed to update event: ' . $e->getMessage());
	    }
	}

    /**
     * Delete event by slug
     */
    public function destroyEvent($slug)
    {
        $event = GalleryEvent::where('slug', $slug)->firstOrFail();

        DB::beginTransaction();

        try {
            File::deleteDirectory(public_path('gallery/' . $event->slug));
            $event->delete();
            DB::commit();

            return redirect()
                ->route('gallery.index')
                ->with('success', 'Event deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Upload photos by event slug
     */
    public function uploadPhotos(Request $request, $slug): JsonResponse
    {
        try {
            \Log::info('Upload started for event slug: ' . $slug);
            \Log::info('Files count: ' . count($request->file('photos', [])));
            
            $request->validate([
                'photos' => 'required|array',
                'photos.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480'
            ]);

            $event = GalleryEvent::where('slug', $slug)->firstOrFail();
            \Log::info('Event found: ' . $event->slug);

            // Create all necessary directories
            $folders = ['originals', 'thumbnails', 'small', 'medium', 'large'];
            foreach ($folders as $folder) {
                $path = public_path("gallery/{$event->slug}/{$folder}");
                \Log::info('Checking directory: ' . $path);
                
                if (!File::exists($path)) {
                    \Log::info('Creating directory: ' . $path);
                    if (!File::makeDirectory($path, 0755, true)) {
                        throw new \Exception("Failed to create directory: " . $path);
                    }
                }
                
                if (!is_writable($path)) {
                    \Log::error('Directory not writable: ' . $path);
                    throw new \Exception("Directory is not writable: " . $path);
                }
            }

            DB::beginTransaction();

            try {
                $uploaded = [];
                $uploadedCount = 0;

                foreach ($request->file('photos') as $index => $photo) {
                    \Log::info('Processing file ' . ($index + 1) . ': ' . $photo->getClientOriginalName());
                    
                    if (!$photo->isValid()) {
                        \Log::error('File is not valid: ' . $photo->getError());
                        continue;
                    }

                    $extension = $photo->getClientOriginalExtension();
                    $filename = now()->format('YmdHis') . '_' . Str::random(15) . '.' . $extension;
                    \Log::info('Generated filename: ' . $filename);
                    
                    // Get the temp file path
                    $tempPath = $photo->getRealPath();
                    \Log::info('Temp path: ' . $tempPath);
                    
                    if (!file_exists($tempPath)) {
                        throw new \Exception("Temp file does not exist: " . $tempPath);
                    }
                    
                    // Read the file contents
                    $fileContents = file_get_contents($tempPath);
                    
                    if ($fileContents === false) {
                        throw new \Exception("Failed to read file: " . $tempPath);
                    }
                    
                    \Log::info('File size: ' . strlen($fileContents) . ' bytes');
                    
                    // Save to originals
                    $originalPath = public_path("gallery/{$event->slug}/originals/{$filename}");
                    \Log::info('Saving to: ' . $originalPath);
                    
                    // Try to save the file
                    $bytesWritten = file_put_contents($originalPath, $fileContents);
                    
                    if ($bytesWritten === false) {
                        throw new \Exception("Failed to write file: " . $originalPath);
                    }
                    
                    if ($bytesWritten === 0) {
                        throw new \Exception("File was written with 0 bytes: " . $originalPath);
                    }
                    
                    \Log::info('Bytes written: ' . $bytesWritten);
                    
                    // Verify the file was saved
                    if (!file_exists($originalPath)) {
                        throw new \Exception("File does not exist after save: " . $originalPath);
                    }
                    
                    if (!is_readable($originalPath)) {
                        throw new \Exception("File is not readable: " . $originalPath);
                    }
                    
                    \Log::info('File saved successfully');

                    // Get image dimensions from the saved file
                    $imageInfo = getimagesize($originalPath);
                    $width = $imageInfo[0] ?? 0;
                    $height = $imageInfo[1] ?? 0;
                    \Log::info('Image dimensions: ' . $width . 'x' . $height);

                    // Generate unique slug for photo
                    $photoSlug = Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . Str::random(6);
                    while (GalleryPhoto::where('slug', $photoSlug)->exists()) {
                        $photoSlug = Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . Str::random(6);
                    }

                    // Create thumbnails
                    try {
                        $this->createThumbnailGD($originalPath, public_path("gallery/{$event->slug}/thumbnails/{$filename}"), 300, 200);
                        $this->resizeImageGD($originalPath, public_path("gallery/{$event->slug}/small/{$filename}"), 800);
                        $this->resizeImageGD($originalPath, public_path("gallery/{$event->slug}/medium/{$filename}"), 1400);
                        $this->resizeImageGD($originalPath, public_path("gallery/{$event->slug}/large/{$filename}"), 2200);
                        \Log::info('Thumbnails created successfully');
                    } catch (\Exception $e) {
                        \Log::warning("Image processing failed for {$filename}: " . $e->getMessage());
                    }

                    // Create database record with slug
                    $galleryPhoto = GalleryPhoto::create([
                        'event_id' => $event->id,
                        'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME),
                        'original_name' => $photo->getClientOriginalName(),
                        'file_name' => $filename,
                        'slug' => $photoSlug,
                        'extension' => $extension,
                        'mime_type' => $photo->getMimeType(),
                        'file_size' => $photo->getSize(),
                        'width' => $width,
                        'height' => $height,
                        'original_path' => "gallery/{$event->slug}/originals/{$filename}",
                        'thumbnail_path' => "gallery/{$event->slug}/thumbnails/{$filename}",
                        'small_path' => "gallery/{$event->slug}/small/{$filename}",
                        'medium_path' => "gallery/{$event->slug}/medium/{$filename}",
                        'large_path' => "gallery/{$event->slug}/large/{$filename}",
                        'uploaded_by' => auth()->id()
                    ]);

                    \Log::info('Database record created with ID: ' . $galleryPhoto->id . ' Slug: ' . $galleryPhoto->slug);

                    $uploaded[] = [
                        'id' => $galleryPhoto->id,
                        'slug' => $galleryPhoto->slug,
                        'filename' => $filename,
                        'original' => $photo->getClientOriginalName()
                    ];
                    
                    $uploadedCount++;
                }

                DB::commit();

                \Log::info('Upload completed successfully: ' . $uploadedCount . ' files');

                return response()->json([
                    'success' => true,
                    'message' => $uploadedCount . ' photos uploaded successfully.',
                    'uploaded' => $uploadedCount,
                    'files' => $uploaded
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                
                \Log::error('Upload error: ' . $e->getMessage());
                \Log::error('Upload trace: ' . $e->getTraceAsString());

                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            \Log::error('Upload trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a thumbnail with exact dimensions (crop)
     */
    private function createThumbnailGD($sourcePath, $destPath, $width, $height)
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception("Source file does not exist: " . $sourcePath);
        }
        
        if (!is_readable($sourcePath)) {
            throw new \Exception("Source file is not readable: " . $sourcePath);
        }
        
        list($origWidth, $origHeight) = getimagesize($sourcePath);
        
        if ($origWidth === false || $origHeight === false) {
            throw new \Exception("Could not get image dimensions for: " . $sourcePath);
        }
        
        $thumb = imagecreatetruecolor($width, $height);
        $source = $this->createImageFromFile($sourcePath);
        
        // Calculate crop coordinates for center crop
        $cropX = max(0, ($origWidth - $height * ($origWidth / $origHeight)) / 2);
        $cropY = max(0, ($origHeight - $width * ($origHeight / $origWidth)) / 2);
        $cropWidth = min($origWidth, $height * ($origWidth / $origHeight));
        $cropHeight = min($origHeight, $width * ($origHeight / $origWidth));
        
        imagecopyresampled($thumb, $source, 0, 0, $cropX, $cropY, $width, $height, $cropWidth, $cropHeight);
        
        $this->saveImage($thumb, $destPath);
        imagedestroy($thumb);
        imagedestroy($source);
    }

    /**
     * Resize image maintaining aspect ratio
     */
    private function resizeImageGD($sourcePath, $destPath, $maxWidth)
    {
        if (!file_exists($sourcePath)) {
            throw new \Exception("Source file does not exist: " . $sourcePath);
        }
        
        if (!is_readable($sourcePath)) {
            throw new \Exception("Source file is not readable: " . $sourcePath);
        }
        
        list($origWidth, $origHeight) = getimagesize($sourcePath);
        
        if ($origWidth === false || $origHeight === false) {
            throw new \Exception("Could not get image dimensions for: " . $sourcePath);
        }
        
        // Calculate new dimensions maintaining aspect ratio
        $ratio = $origWidth / $origHeight;
        if ($origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $ratio;
        } else {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }
        
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        $source = $this->createImageFromFile($sourcePath);
        
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        
        $this->saveImage($thumb, $destPath);
        imagedestroy($thumb);
        imagedestroy($source);
    }

    /**
     * Create image resource from file based on mime type
     */
    private function createImageFromFile($path)
    {
        if (!file_exists($path)) {
            throw new \Exception("File does not exist: " . $path);
        }
        
        $info = getimagesize($path);
        
        if ($info === false) {
            throw new \Exception("Unable to get image info for: " . $path);
        }
        
        $mime = $info['mime'];
        
        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    return imagecreatefromwebp($path);
                }
                return imagecreatefromjpeg($path);
            default:
                throw new \Exception("Unsupported image type: " . $mime);
        }
    }

    /**
     * Save image based on extension
     */
    private function saveImage($resource, $path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        switch ($extension) {
            case 'png':
                imagepng($resource, $path, 9);
                break;
            case 'gif':
                imagegif($resource, $path);
                break;
            case 'webp':
                imagewebp($resource, $path, 80);
                break;
            default:
                imagejpeg($resource, $path, 90);
                break;
        }
    }

    /**
     * Process event images
     */
    public function processEventImages($slug, ImageProcessor $processor)
    {
        $event = GalleryEvent::where('slug', $slug)->firstOrFail();
        $processor->processEvent($event);

        return redirect()
            ->back()
            ->with('success', 'Images processed successfully.');
    }

    /**
     * View photo by slug
     */
    public function viewPhoto($slug)
    {
        $photo = GalleryPhoto::where('slug', $slug)->firstOrFail();

        $previous = GalleryPhoto::where('event_id', $photo->event_id)
            ->where('id', '<', $photo->id)
            ->orderByDesc('id')
            ->first();

        $next = GalleryPhoto::where('event_id', $photo->event_id)
            ->where('id', '>', $photo->id)
            ->orderBy('id')
            ->first();

        return view('gallery.viewer', compact('photo', 'previous', 'next'));
    }

    /**
     * Search photos by event slug
     */
    public function search(Request $request, $slug)
    {
        $event = GalleryEvent::where('slug', $slug)->firstOrFail();
        
        $search = trim($request->search);

        $photos = GalleryPhoto::where('event_id', $event->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('original_name', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('gallery.partials.photos', compact('photos'));
    }

    /**
     * Record download by photo slug
     */
    public function recordDownload($slug)
    {
        try {
            $photo = GalleryPhoto::where('slug', $slug)->firstOrFail();
            $photo->increment('downloads');

            return response()->json([
                'success' => true,
                'downloads' => $photo->downloads
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record download'
            ], 500);
        }
    }

    /**
     * Get download options by photo slug
     */
    public function downloadOptions($slug)
    {
        $photo = GalleryPhoto::where('slug', $slug)->firstOrFail();

        return response()->json([
            'original' => route('gallery.download', [$photo->slug, 'original']),
            'large' => route('gallery.download', [$photo->slug, 'large']),
            'medium' => route('gallery.download', [$photo->slug, 'medium']),
            'small' => route('gallery.download', [$photo->slug, 'small']),
            'thumbnail' => route('gallery.download', [$photo->slug, 'thumbnail'])
        ]);
    }

    /**
     * Download photo by slug
     */
    public function downloadPhoto($slug, $size)
	{
	    try {
	        $photo = GalleryPhoto::where('slug', $slug)->firstOrFail();
	
	        $allowed = ['original', 'large', 'medium', 'small', 'thumbnail'];
	
	        if (!in_array($size, $allowed)) {
	            return response()->json(['error' => 'Invalid size'], 400);
	        }
	
	        $path = null;
	        switch ($size) {
	            case 'original':
	                $path = $photo->original_path;
	                break;
	            case 'large':
	                $path = $photo->large_path;
	                break;
	            case 'medium':
	                $path = $photo->medium_path;
	                break;
	            case 'small':
	                $path = $photo->small_path;
	                break;
	            case 'thumbnail':
	                $path = $photo->thumbnail_path;
	                break;
	        }
	
	        if (empty($path)) {
	            $path = $photo->original_path;
	        }
	
	        $fullPath = public_path($path);
	
	        if (!File::exists($fullPath)) {
	            $fullPath = public_path($photo->original_path);
	            if (!File::exists($fullPath)) {
	                return response()->json(['error' => 'File not found'], 404);
	            }
	        }
	
	        // Only increment once here - this is the only place that should increment
	        $photo->increment('downloads');
	
	        return response()->download(
	            $fullPath,
	            $photo->original_name,
	            [
	                'Content-Type' => $photo->mime_type ?? 'application/octet-stream',
	                'Content-Disposition' => 'attachment; filename="' . $photo->original_name . '"'
	            ]
	        );
	
	    } catch (\Exception $e) {
	        \Log::error('Download error: ' . $e->getMessage());
	        return response()->json(['error' => 'Download failed: ' . $e->getMessage()], 500);
	    }
	}
	/**
 * Delete a single photo
 */
	public function destroyPhoto(Request $request, $slug)
	{
	    try {
	        // Find the photo by slug
	        $photo = GalleryPhoto::where('slug', $slug)->firstOrFail();
	        $eventId = $photo->event_id;
	        $eventSlug = $photo->event->slug;
	        
	        // Get the file paths
	        $originalPath = public_path($photo->original_path);
	        $thumbnailPath = public_path($photo->thumbnail_path);
	        $smallPath = public_path($photo->small_path);
	        $mediumPath = public_path($photo->medium_path);
	        $largePath = public_path($photo->large_path);
	        
	        // Delete all image files
	        $deletedFiles = 0;
	        $paths = [$originalPath, $thumbnailPath, $smallPath, $mediumPath, $largePath];
	        
	        foreach ($paths as $path) {
	            if ($path && File::exists($path)) {
	                File::delete($path);
	                $deletedFiles++;
	            }
	        }
	        
	        // Delete the database record
	        $photo->delete();
	        
	        // Update the event's photo count
	        $event = GalleryEvent::find($eventId);
	        if ($event) {
	            $event->total_photos = GalleryPhoto::where('event_id', $eventId)->count();
	            $event->save();
	        }
	        
	        \Log::info("Photo deleted: {$photo->original_name} (ID: {$photo->id}) - {$deletedFiles} files removed");
	        
	        // Check if request is AJAX/JSON
	        if ($request->ajax() || $request->wantsJson()) {
	            return response()->json([
	                'success' => true,
	                'message' => 'Photo deleted successfully.',
	                'photo_id' => $photo->id
	            ]);
	        }
	        
	        // Redirect back with success message (for non-AJAX requests)
	        return redirect()
	            ->route('gallery.show', $eventSlug)
	            ->with('success', 'Photo deleted successfully.');
	            
	    } catch (\Exception $e) {
	        \Log::error('Delete photo error: ' . $e->getMessage());
	        \Log::error('Delete photo trace: ' . $e->getTraceAsString());
	        
	        if ($request->ajax() || $request->wantsJson()) {
	            return response()->json([
	                'success' => false,
	                'message' => 'Failed to delete photo: ' . $e->getMessage()
	            ], 500);
	        }
	        
	        return redirect()
	            ->back()
	            ->with('error', 'Failed to delete photo: ' . $e->getMessage());
	    }
	}
}