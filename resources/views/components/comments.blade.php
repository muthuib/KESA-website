@props(['blog'])

<div class="comments-wrapper" id="comments-wrapper" data-blog-id="{{ $blog->id }}" data-user-id="{{ auth()->id() }}">
    <div class="comments-container">
        <!-- Comments Header - Facebook Style -->
        <div class="comments-header">
            <div class="header-left">
                <h3 class="comments-title">
                    <span id="commentCount">{{ $blog->comment_count ?? 0 }}</span> Comments
                </h3>
            </div>
            <div class="header-right">
                <div class="sort-dropdown">
                    <button type="button" class="sort-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-sort"></i> Sort by: <span id="currentSort">Latest</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="sort-menu">
                        <li><a class="sort-item active" data-sort="latest" href="#">Latest</a></li>
                        <li><a class="sort-item" data-sort="oldest" href="#">Oldest</a></li>
                        <li><a class="sort-item" data-sort="popular" href="#">Most Liked</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Comment Form - Facebook Style -->
        <div class="comment-form-section" id="commentFormSection">
            @auth
                <div class="comment-form-wrapper">
                    <div class="comment-avatar-wrapper">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="comment-avatar-img">
                    </div>
                    <div class="comment-form-container">
                        <form id="commentForm" class="comment-form">
                            @csrf
                            <input type="hidden" name="parent_id" id="parentId" value="">
                            <div class="comment-input-wrapper">
                                <textarea name="content" id="commentContent" 
                                          class="comment-input" 
                                          rows="1" 
                                          placeholder="Write a comment..." 
                                          onfocus="this.rows=3" 
                                          onblur="if(this.value=='') this.rows=1"
                                          required></textarea>
                                <div class="comment-form-actions" style="display:none;">
                                    <button type="button" class="action-cancel" onclick="window.cancelComment()">Cancel</button>
                                    <button type="submit" class="action-submit">
                                        <i class="fas fa-paper-plane"></i> Post
                                    </button>
                                </div>
                            </div>
                            <div id="replyIndicator" class="reply-indicator" style="display:none;">
                                <i class="fas fa-reply"></i>
                                Replying to <strong id="replyToName"></strong>
                                <button type="button" class="cancel-reply-btn" onclick="window.cancelReply()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div id="commentError" class="comment-error" style="display:none;"></div>
                            <div id="commentSuccess" class="comment-success" style="display:none;"></div>
                        </form>
                    </div>
                </div>
            @else
                <div class="guest-prompt">
                    <div class="guest-prompt-content">
                        <i class="fas fa-user-circle"></i>
                        <p>
                            <a href="{{ route('login') }}" class="guest-link">Log In</a> 
                            or <a href="{{ route('register') }}" class="guest-link">Sign Up</a> 
                            to join the conversation
                        </p>
                    </div>
                    <div class="guest-comment-form mt-3" id="guestCommentFormWrapper">
                        <form id="guestCommentForm" class="comment-form">
                            @csrf
                            <input type="hidden" name="parent_id" id="guestParentId" value="">
                            <input type="hidden" name="guest" value="true">
                            <div class="guest-input-group">
                                <div class="guest-fields">
                                    <input type="text" name="guest_name" class="guest-input" placeholder="Your Name" required>
                                    <input type="email" name="guest_email" class="guest-input" placeholder="Your Email" required>
                                </div>
                                <div class="guest-textarea-wrapper">
                                    <textarea name="content" class="guest-textarea" rows="2" placeholder="Write a comment..." required></textarea>
                                    <div class="guest-form-actions">
                                        <button type="submit" class="guest-submit-btn">
                                            <i class="fas fa-paper-plane"></i> Post
                                        </button>
                                    </div>
                                </div>
                                <div id="replyIndicatorGuest" class="reply-indicator" style="display:none;">
                                    <i class="fas fa-reply"></i>
                                    Replying to <strong id="replyToNameGuest"></strong>
                                    <button type="button" class="cancel-reply-btn" onclick="window.cancelGuestReply()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div id="guestCommentError" class="comment-error" style="display:none;"></div>
                            </div>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Comments List - Facebook Style -->
        <div class="comments-list" id="commentsList">
            <div id="loadingIndicator" class="loading-spinner">
                <div class="spinner"></div>
                <p>Loading comments...</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/comments.js') }}"></script>
@endpush