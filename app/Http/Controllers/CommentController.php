<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReport;
use App\Models\CommentSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Get comments for a blog
     */
    // public function index(Blog $blog, Request $request)
    // {
    //     $sort = $request->get('sort', 'latest');
    //     $perPage = $request->get('per_page', 20);

    //     $query = Comment::forBlog($blog->id)
    //         ->approved()
    //         ->whereNull('parent_id')
    //         ->with(['user', 'replies' => function($q) {
    //             $q->with('user');
    //         }]);

    //     // Apply sorting
    //     switch ($sort) {
    //         case 'oldest':
    //             $query->orderBy('created_at', 'asc');
    //             break;
    //         case 'popular':
    //             $query->orderBy('likes', 'desc')
    //                   ->orderBy('created_at', 'desc');
    //             break;
    //         case 'latest':
    //         default:
    //             $query->orderBy('created_at', 'desc');
    //             break;
    //     }

    //     $comments = $query->paginate($perPage);

    //     // Add user interaction flags
    //     if (auth()->check()) {
    //         $commentIds = $comments->pluck('id')->toArray();
    //         $likedIds = CommentLike::whereIn('comment_id', $commentIds)
    //             ->where('user_id', auth()->id())
    //             ->pluck('comment_id')
    //             ->toArray();
            
    //         $comments->each(function($comment) use ($likedIds) {
    //             $comment->setAttribute('user_liked', in_array($comment->id, $likedIds));
    //             if ($comment->replies) {
    //                 $comment->replies->each(function($reply) use ($likedIds) {
    //                     $reply->setAttribute('user_liked', in_array($reply->id, $likedIds));
    //                 });
    //             }
    //         });
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'comments' => $comments,
    //         'total' => $blog->comments()->where('is_approved', true)->count(),
    //         'pending' => $blog->comments()->where('is_approved', false)->count(),
    //     ]);
    // }

    public function index(Blog $blog, Request $request)
	{
	    try {
	        $sort = $request->get('sort', 'latest');
	        $perPage = $request->get('per_page', 20);
	
	        $query = Comment::forBlog($blog->id)
	            ->approved()
	            ->whereNull('parent_id')
	            ->with(['user', 'replies.user']); // Properly loads user with correct relationship
	
	        switch ($sort) {
	            case 'oldest':
	                $query->orderBy('created_at', 'asc');
	                break;
	            case 'popular':
	                $query->orderBy('likes', 'desc')
	                      ->orderBy('created_at', 'desc');
	                break;
	            case 'latest':
	            default:
	                $query->orderBy('created_at', 'desc');
	                break;
	        }
	
	        $comments = $query->paginate($perPage);
	
	        // Add user interaction flags
	        if (auth()->check()) {
	            $commentIds = $comments->pluck('id')->toArray();
	            $likedIds = CommentLike::whereIn('comment_id', $commentIds)
	                ->where('user_id', auth()->id())
	                ->pluck('comment_id')
	                ->toArray();
	            
	            $comments->each(function($comment) use ($likedIds) {
	                $comment->setAttribute('user_liked', in_array($comment->id, $likedIds));
	                if ($comment->replies) {
	                    $comment->replies->each(function($reply) use ($likedIds) {
	                        $reply->setAttribute('user_liked', in_array($reply->id, $likedIds));
	                    });
	                }
	            });
	        }
	
	        // Debug: Check if user is loaded
	        if ($comments->count() > 0) {
	            $first = $comments->first();
	            \Log::info('Comment user debug:', [
	                'comment_id' => $first->id,
	                'user_id' => $first->user_id,
	                'has_user' => $first->relationLoaded('user'),
	                'user_exists' => $first->user ? true : false,
	                'user_name' => $first->user ? ($first->user->FIRST_NAME ?? 'No name') : 'No user'
	            ]);
	        }
	
	        return response()->json([
	            'success' => true,
	            'comments' => $comments,
	            'total' => $blog->comments()->where('is_approved', true)->count(),
	            'pending' => $blog->comments()->where('is_approved', false)->count(),
	        ]);
	
	    } catch (\Exception $e) {
	        \Log::error('Error loading comments: ' . $e->getMessage());
	        return response()->json([
	            'success' => false,
	            'message' => 'Failed to load comments.'
	        ], 500);
	    }
	}

    /**
     * Store a new comment
     */
    public function store(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:2|max:5000',
            'parent_id' => 'nullable|exists:comments,id',
            'guest_name' => 'required_if:guest,true|string|max:100',
            'guest_email' => 'required_if:guest,true|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check for spam
        $this->checkForSpam($request, $blog);

        $comment = DB::transaction(function () use ($request, $blog) {
            $comment = Comment::create([
                'blog_id' => $blog->id,
                'user_id' => auth()->id(),
                'parent_id' => $request->parent_id,
                'content' => $request->content,
                'guest_name' => $request->guest_name,
                'guest_email' => $request->guest_email,
                'ip_address' => $request->ip(),
                'is_approved' => $this->shouldAutoApprove($request),
            ]);

            // Auto-subscribe user if requested
            if (auth()->check() && $request->has('subscribe') && $request->subscribe) {
                CommentSubscription::updateOrCreate(
                    [
                        'blog_id' => $blog->id,
                        'user_id' => auth()->id()
                    ],
                    ['is_active' => true]
                );
            }

            return $comment;
        });

        $comment->load(['user', 'replies']);

        return response()->json([
            'success' => true,
            'message' => $comment->is_approved ? 'Comment added successfully!' : 'Comment submitted for approval.',
            'comment' => $comment,
            'approved' => $comment->is_approved,
        ], 201);
    }

    /**
     * Update a comment
     */
    // public function update(Request $request, Comment $comment)
    // {
    //     $this->authorize('update', $comment);

    //     $validator = Validator::make($request->all(), [
    //         'content' => 'required|string|min:2|max:5000',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $comment->update(['content' => $request->content]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Comment updated successfully!',
    //         'comment' => $comment
    //     ]);
    // }

    // /**
    //  * Delete a comment
    //  */
    // public function destroy(Comment $comment)
    // {
    //     $this->authorize('delete', $comment);

    //     $comment->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Comment deleted successfully!'
    //     ]);
    // }
/**
 * Update a comment
 */
public function update(Request $request, Comment $comment)
{
    // Check if user is logged in
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Please login to edit a comment.'
        ], 401);
    }

    // Check if user owns the comment
    if (auth()->id() !== $comment->user_id) {
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to edit this comment.'
        ], 403);
    }

    $validator = Validator::make($request->all(), [
        'content' => 'required|string|min:2|max:5000',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $comment->update(['content' => $request->content]);

    return response()->json([
        'success' => true,
        'message' => 'Comment updated successfully!',
        'comment' => $comment
    ]);
}

/**
 * Delete a comment
 */
public function destroy(Comment $comment)
{
    // Check if user is logged in
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Please login to delete a comment.'
        ], 401);
    }

    // Check if user owns the comment
    if (auth()->id() !== $comment->user_id) {
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to delete this comment.'
        ], 403);
    }

    $comment->delete();

    return response()->json([
        'success' => true,
        'message' => 'Comment deleted successfully!'
    ]);
}
    /**
     * Like a comment
     */
    public function like(Request $request, Comment $comment)
    {
        $userId = auth()->id();
        
        // Check if already liked
        $existingLike = CommentLike::where('comment_id', $comment->id)
            ->when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            })
            ->when(!$userId, function($q) use ($request) {
                return $q->where('ip_address', $request->ip());
            })
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $comment->decrement('likes');
            $liked = false;
        } else {
            CommentLike::create([
                'comment_id' => $comment->id,
                'user_id' => $userId,
                'guest_id' => !$userId ? session()->getId() : null,
                'ip_address' => $request->ip(),
            ]);
            $comment->increment('likes');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'likes' => $comment->fresh()->likes,
            'liked' => $liked
        ]);
    }

    /**
     * Report a comment
     */
    public function report(Request $request, Comment $comment)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to report a comment.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if already reported
        $existing = CommentReport::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reported this comment.'
            ], 422);
        }

        CommentReport::create([
            'comment_id' => $comment->id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'details' => $request->details,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment reported successfully. We will review it.'
        ]);
    }

    /**
     * Subscribe to comments
     */
    public function subscribe(Request $request, Blog $blog)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to subscribe.'
            ], 401);
        }

        $subscription = CommentSubscription::updateOrCreate(
            [
                'blog_id' => $blog->id,
                'user_id' => auth()->id(),
            ],
            [
                'email' => auth()->user()->email,
                'is_active' => true
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'You are now subscribed to comments on this blog.',
            'subscribed' => true
        ]);
    }

    /**
     * Unsubscribe from comments
     */
    public function unsubscribe(Request $request, Blog $blog)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to unsubscribe.'
            ], 401);
        }

        $subscription = CommentSubscription::where('blog_id', $blog->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($subscription) {
            $subscription->update(['is_active' => false]);
        }

        return response()->json([
            'success' => true,
            'message' => 'You have unsubscribed from comments on this blog.',
            'subscribed' => false
        ]);
    }

    /**
     * Check for spam
     */
    private function checkForSpam(Request $request, Blog $blog)
    {
        // Check for duplicate comment
        $recent = Comment::where('blog_id', $blog->id)
            ->where('content', $request->content)
            ->when(auth()->check(), function($q) {
                return $q->where('user_id', auth()->id());
            })
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($recent) {
            abort(422, 'You already posted this comment recently.');
        }

        // Rate limiting
        $count = Comment::when(auth()->check(), function($q) {
                return $q->where('user_id', auth()->id());
            })
            ->where('ip_address', $request->ip())
            ->where('created_at', '>', now()->subMinutes(10))
            ->count();

        if ($count >= 5) {
            abort(429, 'Too many comments. Please wait a moment before posting again.');
        }

        // Basic spam word check
        $spamWords = ['casino', 'viagra', 'porn', 'xxx', 'gambling', 'crypto', 'bitcoin'];
        $content = strtolower($request->content);
        foreach ($spamWords as $word) {
            if (str_contains($content, $word)) {
                abort(422, 'Your comment contains prohibited content.');
            }
        }
    }

    /**
     * Determine if comment should be auto-approved
     */
    private function shouldAutoApprove(Request $request)
    {
        // Auto-approve if user is authenticated and has previous approved comments
        if (auth()->check()) {
            $previousComments = Comment::where('user_id', auth()->id())
                ->where('is_approved', true)
                ->count();
            
            return $previousComments > 0;
        }

        // Auto-approve for guests with valid email
        return $request->guest_email && filter_var($request->guest_email, FILTER_VALIDATE_EMAIL);
    }
}