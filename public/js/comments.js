class CommentSystem {
    constructor(wrapperId) {
        this.wrapper = document.getElementById(wrapperId);
        if (!this.wrapper) {
            console.error('Comments wrapper not found!');
            return;
        }
        
        this.blogId = this.wrapper.dataset.blogId;
        this.userId = this.wrapper.dataset.userId || null;
        this.currentPage = 1;
        this.currentSort = 'latest';
        this.hasMore = true;
        this.isLoading = false;
        this.displayLimit = 2; // Show only 2 comments initially (Facebook style)
        this.comments = [];
        this.allCommentsLoaded = false;
        this.replyStates = {}; // Track reply visibility per comment
        
        console.log('CommentSystem initialized with blogId:', this.blogId);
        this.init();
    }

    init() {
        this.loadComments();
        this.setupEventListeners();
        this.checkSubscriptionStatus();
    }

    setupEventListeners() {
        // ===== SORT DROPDOWN - Facebook Style =====
        const sortToggle = this.wrapper.querySelector('.sort-toggle');
        const sortMenu = this.wrapper.querySelector('.sort-menu');

        if (sortToggle && sortMenu) {
            sortToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sortMenu.classList.toggle('show');
            });

            document.addEventListener('click', () => {
                sortMenu.classList.remove('show');
            });

            this.wrapper.querySelectorAll('.sort-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const sort = item.dataset.sort;
                    this.currentSort = sort;
                    this.currentPage = 1;
                    this.hasMore = true;
                    this.comments = [];
                    
                    this.wrapper.querySelectorAll('.sort-item').forEach(el => {
                        el.classList.remove('active');
                    });
                    item.classList.add('active');
                    
                    const sortLabel = this.wrapper.querySelector('#currentSort');
                    if (sortLabel) {
                        sortLabel.textContent = item.textContent.trim();
                    }
                    
                    sortMenu.classList.remove('show');
                    this.loadComments();
                });
            });
        }

        // ===== COMMENT INPUT - Facebook Style =====
        const commentInput = this.wrapper.querySelector('.comment-input');
        const formActions = this.wrapper.querySelector('.comment-form-actions');

        if (commentInput && formActions) {
            commentInput.addEventListener('focus', () => {
                formActions.style.display = 'flex';
                commentInput.rows = 3;
            });
            
            commentInput.addEventListener('blur', () => {
                if (!commentInput.value.trim()) {
                    setTimeout(() => {
                        formActions.style.display = 'none';
                        commentInput.rows = 1;
                    }, 200);
                }
            });

            commentInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    const form = this.wrapper.querySelector('#commentForm');
                    if (form) {
                        form.dispatchEvent(new Event('submit'));
                    }
                }
            });
        }

        // ===== COMMENT FORM =====
        const form = this.wrapper.querySelector('#commentForm');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        // ===== GUEST COMMENT FORM =====
        const guestForm = this.wrapper.querySelector('#guestCommentForm');
        if (guestForm) {
            guestForm.addEventListener('submit', (e) => this.handleGuestSubmit(e));
        }

        // ===== SUBSCRIBE BUTTON =====
        const subscribeBtn = this.wrapper.querySelector('#subscribeBtn');
        if (subscribeBtn) {
            subscribeBtn.addEventListener('click', () => this.toggleSubscribe());
        }

        // ===== EVENT DELEGATION FOR DYNAMIC ELEMENTS =====
        const list = this.wrapper.querySelector('#commentsList');
        if (list) {
            list.addEventListener('click', (e) => {
                // Handle "See All Comments" button
                const seeAllBtn = e.target.closest('.see-all-comments-btn');
                if (seeAllBtn) {
                    const hiddenComments = this.wrapper.querySelectorAll('.comment-item.hidden-comment');
                    hiddenComments.forEach(el => el.classList.remove('hidden-comment'));
                    seeAllBtn.style.display = 'none';
                    
                    const showLessBtn = this.wrapper.querySelector('.show-less-comments-btn');
                    if (showLessBtn) showLessBtn.style.display = 'block';
                }

                // Handle "Show less" button
                const showLessBtn = e.target.closest('.show-less-comments-btn');
                if (showLessBtn) {
                    const allComments = this.wrapper.querySelectorAll('.comment-item:not(.comment-reply)');
                    allComments.forEach((el, index) => {
                        if (index >= this.displayLimit) {
                            el.classList.add('hidden-comment');
                        }
                    });
                    showLessBtn.style.display = 'none';
                    
                    const seeAllBtn = this.wrapper.querySelector('.see-all-comments-btn');
                    if (seeAllBtn) seeAllBtn.style.display = 'block';
                }

                // ===== HANDLE "VIEW REPLIES" BUTTON - FIXED =====
                const viewRepliesBtn = e.target.closest('.view-replies-btn');
                if (viewRepliesBtn) {
                    const commentId = viewRepliesBtn.dataset.commentId;
                    const repliesContainer = this.wrapper.querySelector(`#replies-container-${commentId}`);
                    
                    if (repliesContainer) {
                        // Toggle replies visibility for THIS comment only
                        const isHidden = repliesContainer.classList.contains('replies-hidden');
                        
                        if (isHidden) {
                            // Show replies for this comment
                            this.showReplies(commentId);
                        } else {
                            // Hide replies for this comment
                            this.hideReplies(commentId);
                        }
                    }
                }
            });
        }
    }

    // ===== SHOW REPLIES FOR A SPECIFIC COMMENT =====
    showReplies(commentId) {
        const repliesContainer = this.wrapper.querySelector(`#replies-container-${commentId}`);
        if (!repliesContainer) return;
        
        const allReplies = repliesContainer.querySelectorAll('.reply-item');
        const viewBtn = repliesContainer.querySelector('.view-replies-btn');
        
        // Show all replies
        repliesContainer.classList.remove('replies-hidden');
        allReplies.forEach(el => el.classList.remove('hidden-reply'));
        
        // Update button text
        if (viewBtn) {
            viewBtn.innerHTML = `<i class="fas fa-chevron-up"></i> Hide replies (${allReplies.length})`;
            viewBtn.classList.add('hide-replies');
        }
        
        // Update state
        this.replyStates[commentId] = 'visible';
        console.log(`Replies shown for comment ${commentId}`);
    }

    // ===== HIDE REPLIES FOR A SPECIFIC COMMENT =====
    hideReplies(commentId) {
        const repliesContainer = this.wrapper.querySelector(`#replies-container-${commentId}`);
        if (!repliesContainer) return;
        
        const allReplies = repliesContainer.querySelectorAll('.reply-item');
        const viewBtn = repliesContainer.querySelector('.view-replies-btn');
        
        // Hide all replies
        repliesContainer.classList.add('replies-hidden');
        allReplies.forEach(el => el.classList.add('hidden-reply'));
        
        // Update button text
        if (viewBtn) {
            viewBtn.innerHTML = `<i class="fas fa-chevron-down"></i> View replies (${allReplies.length})`;
            viewBtn.classList.remove('hide-replies');
        }
        
        // Update state
        this.replyStates[commentId] = 'hidden';
        console.log(`Replies hidden for comment ${commentId}`);
    }

    // ===== TOGGLE REPLIES (Alternative method) =====
    toggleReplies(commentId) {
        const repliesContainer = this.wrapper.querySelector(`#replies-container-${commentId}`);
        if (!repliesContainer) return;
        
        const isHidden = repliesContainer.classList.contains('replies-hidden');
        
        if (isHidden) {
            this.showReplies(commentId);
        } else {
            this.hideReplies(commentId);
        }
    }

    // ===== LOAD COMMENTS =====
    loadComments() {
        if (this.isLoading || !this.hasMore) return;
        
        this.isLoading = true;
        this.showLoading();

        const url = `/blogs/${this.blogId}/comments?page=${this.currentPage}&sort=${this.currentSort}`;
        console.log('Loading comments from URL:', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            return response.json();
        })
        .then(data => {
            this.hideLoading();
            
            if (this.currentPage === 1) {
                const list = this.wrapper.querySelector('#commentsList');
                list.innerHTML = '';
                this.comments = [];
                this.replyStates = {}; // Reset reply states
            }

            if (!data.comments || data.comments.data.length === 0 && this.currentPage === 1) {
                this.showEmptyState();
                this.hasMore = false;
            } else if (data.comments && data.comments.data.length > 0) {
                data.comments.data.forEach(comment => {
                    this.comments.push(comment);
                });
                
                this.hasMore = data.comments.next_page_url !== null;
                this.currentPage++;
            }

            const countEl = this.wrapper.querySelector('#commentCount');
            if (countEl && data.total !== undefined) {
                countEl.textContent = data.total;
            }

            this.renderAllComments();
            this.isLoading = false;
        })
        .catch(error => {
            console.error('Error loading comments:', error);
            this.isLoading = false;
            this.hideLoading();
            
            const list = this.wrapper.querySelector('#commentsList');
            if (this.currentPage === 1) {
                list.innerHTML = `
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-exclamation-circle"></i>
                        <h5>Failed to load comments</h5>
                        <p class="text-muted">${error.message}</p>
                        <button class="btn btn-primary mt-2" onclick="window.commentSystem.loadComments()">
                            <i class="fas fa-sync"></i> Retry
                        </button>
                    </div>
                `;
            }
        });
    }

    // ===== RENDER ALL COMMENTS WITH FACEBOOK-STYLE LIMITS =====
    renderAllComments() {
        const list = this.wrapper.querySelector('#commentsList');
        list.innerHTML = '';
        
        if (this.comments.length === 0) {
            this.showEmptyState();
            return;
        }

        // Sort comments based on current sort
        let sortedComments = [...this.comments];
        if (this.currentSort === 'oldest') {
            sortedComments.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        } else if (this.currentSort === 'popular') {
            sortedComments.sort((a, b) => b.likes - a.likes);
        }

        // Render each comment
        sortedComments.forEach((comment, index) => {
            const template = this.createCommentHTML(comment, index);
            const div = document.createElement('div');
            div.innerHTML = template;
            list.appendChild(div.firstElementChild);
        });

        // Add "See All Comments" button if there are more than displayLimit
        if (this.comments.length > this.displayLimit) {
            const seeAllContainer = document.createElement('div');
            seeAllContainer.className = 'see-all-container';
            seeAllContainer.innerHTML = `
                <button class="see-all-comments-btn">
                    <i class="fas fa-chevron-down"></i> See all ${this.comments.length} comments
                </button>
                <button class="show-less-comments-btn" style="display:none;">
                    <i class="fas fa-chevron-up"></i> Show less comments
                </button>
            `;
            list.appendChild(seeAllContainer);
        }

        // Apply initial hiding (show only first 2 comments)
        const allComments = list.querySelectorAll('.comment-item:not(.comment-reply)');
        allComments.forEach((el, index) => {
            if (index >= this.displayLimit) {
                el.classList.add('hidden-comment');
            }
        });

        // Apply initial hiding for replies (all replies hidden initially)
        const allRepliesContainers = list.querySelectorAll('.replies-container');
        allRepliesContainers.forEach(container => {
            container.classList.add('replies-hidden');
            const replies = container.querySelectorAll('.reply-item');
            replies.forEach(el => el.classList.add('hidden-reply'));
            
            // Update button text for each container
            const viewBtn = container.querySelector('.view-replies-btn');
            if (viewBtn) {
                const totalReplies = container.querySelectorAll('.reply-item').length;
                viewBtn.innerHTML = `<i class="fas fa-chevron-down"></i> View replies (${totalReplies})`;
                viewBtn.classList.remove('hide-replies');
            }
        });
    }

    // ===== CREATE COMMENT HTML =====
    createCommentHTML(comment, index) {
        const authorName = comment.author_name || comment.guest_name || 'Guest';
        const isAdmin = comment.user && comment.user.is_admin;
        const userLiked = comment.user_liked || false;
        const avatar = comment.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(authorName)}&background=random`;
        const escapedAuthorName = authorName.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const isGuest = !this.userId;
        const isHidden = index >= this.displayLimit ? 'hidden-comment' : '';
        
        // Get replies - ALL hidden initially
        const replies = comment.replies || [];
        const totalReplies = replies.length;
        const hasReplies = totalReplies > 0;
        
        return `
            <div class="comment-item ${isHidden}" id="comment-${comment.id}" data-comment-id="${comment.id}">
                <div class="comment-avatar-wrapper">
                    <img src="${avatar}" alt="${authorName}" class="comment-avatar">
                </div>
                <div class="comment-content-wrapper">
                    <div class="comment-header">
                        <span class="comment-author">${this.escapeHtml(authorName)}</span>
                        <div class="comment-badge">
                            ${isAdmin ? '<span class="badge badge-admin">Admin</span>' : ''}
                        </div>
                        <span class="comment-date">
                            <i class="far fa-clock"></i> ${comment.time_ago || 'Just now'}
                        </span>
                    </div>
                    <div class="comment-body" id="commentBody-${comment.id}">
                        ${this.escapeHtml(comment.content || '')}
                    </div>
                    <div class="comment-actions">
                        <button class="action-btn reply-btn" onclick="window.handleReplyClick(${comment.id}, '${escapedAuthorName}', ${isGuest})">
                            <i class="fas fa-reply"></i> Reply
                        </button>
                        <button class="action-btn like-btn ${userLiked ? 'liked' : ''}" onclick="window.toggleLike(${comment.id})">
                            <i class="fas fa-heart ${userLiked ? 'text-danger' : ''}"></i>
                            <span class="like-count" id="likes-${comment.id}">${comment.likes || 0}</span>
                        </button>
                        ${this.userId ? `
                            <button class="action-btn report-btn" onclick="window.reportComment(${comment.id})">
                                <i class="fas fa-flag"></i>
                            </button>
                            ${(parseInt(this.userId) === comment.user_id) ? `
                                <button class="action-btn edit-btn" onclick="window.editComment(${comment.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" onclick="window.deleteComment(${comment.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                        ` : ''}
                    </div>
                    ${hasReplies ? `
                        <div class="replies-container replies-hidden" id="replies-container-${comment.id}">
                            ${replies.map(reply => this.createReplyHTML(reply, true)).join('')}
                            <button class="view-replies-btn" data-comment-id="${comment.id}">
                                <i class="fas fa-chevron-down"></i> View replies (${totalReplies})
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    }

    // ===== CREATE REPLY HTML =====
    createReplyHTML(reply, isHidden = true) {
        const authorName = reply.author_name || reply.guest_name || 'Guest';
        const userLiked = reply.user_liked || false;
        const avatar = reply.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(authorName)}&background=random`;
        const escapedAuthorName = authorName.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const isGuest = !this.userId;
        const hiddenClass = isHidden ? 'hidden-reply' : '';
        
        return `
            <div class="comment-item comment-reply reply-item ${hiddenClass}" id="comment-${reply.id}" data-comment-id="${reply.id}">
                <div class="comment-avatar-wrapper">
                    <img src="${avatar}" alt="${authorName}" class="comment-avatar">
                </div>
                <div class="comment-content-wrapper">
                    <div class="comment-header">
                        <span class="comment-author">${this.escapeHtml(authorName)}</span>
                        <span class="comment-date">
                            <i class="far fa-clock"></i> ${reply.time_ago || 'Just now'}
                        </span>
                    </div>
                    <div class="comment-body">
                        ${this.escapeHtml(reply.content || '')}
                    </div>
                    <div class="comment-actions">
                        <button class="action-btn reply-btn" onclick="window.handleReplyClick(${reply.id}, '${escapedAuthorName}', ${isGuest})">
                            <i class="fas fa-reply"></i> Reply
                        </button>
                        <button class="action-btn like-btn ${userLiked ? 'liked' : ''}" onclick="window.toggleLike(${reply.id})">
                            <i class="fas fa-heart ${userLiked ? 'text-danger' : ''}"></i>
                            <span class="like-count" id="likes-${reply.id}">${reply.likes || 0}</span>
                        </button>
                        ${this.userId ? `
                            ${(parseInt(this.userId) === reply.user_id) ? `
                                <button class="action-btn edit-btn" onclick="window.editComment(${reply.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" onclick="window.deleteComment(${reply.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    // ===== ESCAPE HTML =====
    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ===== HANDLE REPLY CLICK =====
    handleReplyClick(commentId, authorName, isGuest) {
        console.log('Reply clicked:', { commentId, authorName, isGuest });
        
        if (isGuest) {
            this.setGuestReply(commentId, authorName);
        } else {
            this.setReply(commentId, authorName);
        }
    }

    // ===== GUEST REPLY =====
    setGuestReply(commentId, authorName) {
        console.log('Setting GUEST reply to:', commentId, authorName);
        
        const guestForm = document.querySelector('.guest-comment-form');
        if (!guestForm) {
            window.location.href = '/login';
            return;
        }
        
        guestForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        const parentInput = document.getElementById('guestParentId');
        const indicator = document.getElementById('replyIndicatorGuest');
        const nameSpan = document.getElementById('replyToNameGuest');
        const contentField = document.querySelector('#guestCommentForm textarea[name="content"]');
        
        if (parentInput && indicator && nameSpan && contentField) {
            parentInput.value = commentId;
            nameSpan.textContent = authorName || 'Guest';
            indicator.style.display = 'flex';
            contentField.focus();
            contentField.style.borderColor = '#1b74e4';
            contentField.style.boxShadow = '0 0 0 2px rgba(27, 116, 228, 0.1)';
            guestForm.classList.add('active');
        }
    }

    cancelGuestReply() {
        const parentInput = document.getElementById('guestParentId');
        const indicator = document.getElementById('replyIndicatorGuest');
        const contentField = document.querySelector('#guestCommentForm textarea[name="content"]');
        const guestForm = document.querySelector('.guest-comment-form');
        
        if (parentInput) parentInput.value = '';
        if (indicator) indicator.style.display = 'none';
        if (contentField) {
            contentField.style.borderColor = '';
            contentField.style.boxShadow = '';
        }
        if (guestForm) {
            guestForm.classList.remove('active');
        }
    }

    // ===== LOGGED IN USER REPLY =====
    setReply(commentId, authorName) {
        const formSection = document.getElementById('commentFormSection');
        if (formSection) {
            formSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        const parentInput = document.getElementById('parentId');
        const indicator = document.getElementById('replyIndicator');
        const nameSpan = document.getElementById('replyToName');
        const contentField = document.getElementById('commentContent');
        const formActions = document.querySelector('.comment-form-actions');
        
        if (parentInput && indicator && nameSpan && contentField) {
            parentInput.value = commentId;
            nameSpan.textContent = authorName || 'Guest';
            indicator.style.display = 'flex';
            contentField.focus();
            contentField.rows = 3;
            contentField.style.borderColor = '#1b74e4';
            contentField.style.boxShadow = '0 0 0 2px rgba(27, 116, 228, 0.1)';
            
            if (formActions) {
                formActions.style.display = 'flex';
            }
        }
    }

    cancelReply() {
        const parentInput = document.getElementById('parentId');
        const indicator = document.getElementById('replyIndicator');
        const contentField = document.getElementById('commentContent');
        const formActions = document.querySelector('.comment-form-actions');
        
        if (parentInput) parentInput.value = '';
        if (indicator) indicator.style.display = 'none';
        if (contentField) {
            contentField.value = '';
            contentField.rows = 1;
            contentField.style.borderColor = '';
            contentField.style.boxShadow = '';
            contentField.blur();
        }
        if (formActions) {
            formActions.style.display = 'none';
        }
    }

    // ===== CANCEL COMMENT =====
    cancelComment() {
        const input = this.wrapper.querySelector('.comment-input');
        const actions = this.wrapper.querySelector('.comment-form-actions');
        const replyIndicator = this.wrapper.querySelector('#replyIndicator');
        
        if (input) {
            input.value = '';
            input.rows = 1;
            input.blur();
            input.style.borderColor = '';
            input.style.boxShadow = '';
        }
        if (actions) {
            actions.style.display = 'none';
        }
        if (replyIndicator) {
            replyIndicator.style.display = 'none';
        }
        const parentInput = this.wrapper.querySelector('#parentId');
        if (parentInput) parentInput.value = '';
    }

    // ===== FORM SUBMISSIONS =====
    handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        
        this.clearErrors();

        const submitBtn = form.querySelector('.action-submit');
        const originalText = submitBtn?.innerHTML;
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
            submitBtn.disabled = true;
        }

        fetch(`/blogs/${this.blogId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (submitBtn) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }

            if (data.success) {
                form.reset();
                document.getElementById('parentId').value = '';
                document.getElementById('replyIndicator').style.display = 'none';
                
                const input = this.wrapper.querySelector('.comment-input');
                const actions = this.wrapper.querySelector('.comment-form-actions');
                if (input) {
                    input.rows = 1;
                    input.blur();
                }
                if (actions) {
                    actions.style.display = 'none';
                }
                
                this.currentPage = 1;
                this.hasMore = true;
                this.comments = [];
                this.replyStates = {};
                this.loadComments();
                
                this.showSuccess(data.message || 'Comment posted successfully!');
            } else {
                this.showError(data.message || 'Failed to post comment.');
                if (data.errors) {
                    const errors = Object.values(data.errors).flat().join('\n');
                    this.showError(errors);
                }
            }
        })
        .catch(error => {
            console.error('Error posting comment:', error);
            if (submitBtn) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
            this.showError('Failed to post comment. Please try again.');
        });
    }

    handleGuestSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        formData.append('guest', 'true');

        this.clearErrors();

        const submitBtn = form.querySelector('.guest-submit-btn');
        const originalText = submitBtn?.innerHTML;
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
            submitBtn.disabled = true;
        }

        fetch(`/blogs/${this.blogId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (submitBtn) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }

            if (data.success) {
                form.reset();
                document.getElementById('guestParentId').value = '';
                document.getElementById('replyIndicatorGuest').style.display = 'none';
                document.querySelector('.guest-comment-form')?.classList.remove('active');
                
                this.currentPage = 1;
                this.hasMore = true;
                this.comments = [];
                this.replyStates = {};
                this.loadComments();
                
                this.showSuccess(data.message || 'Comment posted successfully!');
            } else {
                this.showError(data.message || 'Failed to post comment.');
                if (data.errors) {
                    const errors = Object.values(data.errors).flat().join('\n');
                    this.showError(errors);
                }
            }
        })
        .catch(error => {
            console.error('Error posting guest comment:', error);
            if (submitBtn) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
            this.showError('Failed to post comment. Please try again.');
        });
    }

    // ===== LIKE FUNCTIONALITY =====
    toggleLike(commentId) {
        if (!this.userId) {
            alert('Please login to like a comment.');
            return;
        }

        const likesSpan = document.getElementById(`likes-${commentId}`);
        const commentEl = document.getElementById(`comment-${commentId}`);
        const likeBtn = commentEl ? commentEl.querySelector('.like-btn') : null;
        const heartIcon = likeBtn ? likeBtn.querySelector('i') : null;
        
        if (!likesSpan) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            alert('Security token missing. Please refresh the page.');
            return;
        }

        const originalLikes = parseInt(likesSpan.textContent) || 0;
        const wasLiked = heartIcon ? heartIcon.classList.contains('text-danger') : false;

        if (wasLiked) {
            likesSpan.textContent = originalLikes - 1;
            if (heartIcon) heartIcon.classList.remove('text-danger');
            if (likeBtn) likeBtn.classList.remove('liked');
        } else {
            likesSpan.textContent = originalLikes + 1;
            if (heartIcon) heartIcon.classList.add('text-danger');
            if (likeBtn) likeBtn.classList.add('liked');
        }

        fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                likesSpan.textContent = data.likes;
                if (heartIcon) {
                    if (data.liked) {
                        heartIcon.classList.add('text-danger');
                        if (likeBtn) likeBtn.classList.add('liked');
                    } else {
                        heartIcon.classList.remove('text-danger');
                        if (likeBtn) likeBtn.classList.remove('liked');
                    }
                }
            } else {
                likesSpan.textContent = originalLikes;
                if (heartIcon) {
                    if (wasLiked) {
                        heartIcon.classList.add('text-danger');
                        if (likeBtn) likeBtn.classList.add('liked');
                    } else {
                        heartIcon.classList.remove('text-danger');
                        if (likeBtn) likeBtn.classList.remove('liked');
                    }
                }
                alert(data.message || 'Failed to like comment.');
            }
        })
        .catch(error => {
            console.error('Error toggling like:', error);
            likesSpan.textContent = originalLikes;
            if (heartIcon) {
                if (wasLiked) {
                    heartIcon.classList.add('text-danger');
                    if (likeBtn) likeBtn.classList.add('liked');
                } else {
                    heartIcon.classList.remove('text-danger');
                    if (likeBtn) likeBtn.classList.remove('liked');
                }
            }
            alert('Failed to like comment. Please try again.');
        });
    }

    // ===== REPORT FUNCTIONALITY =====
    reportComment(commentId) {
        if (!this.userId) {
            alert('Please login to report a comment.');
            return;
        }
        
        const reason = prompt('Please tell us why you are reporting this comment:');
        if (!reason) return;

        fetch(`/comments/${commentId}/report`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showSuccess('Comment reported successfully. We will review it.');
            } else {
                this.showError(data.message || 'Failed to report comment.');
            }
        })
        .catch(error => console.error('Error reporting comment:', error));
    }

    // ===== EDIT FUNCTIONALITY =====
    editComment(commentId) {
        const bodyEl = document.getElementById(`commentBody-${commentId}`);
        if (!bodyEl) return;
        
        const currentContent = bodyEl.textContent.trim();
        
        const textarea = document.createElement('textarea');
        textarea.className = 'edit-textarea';
        textarea.value = currentContent;
        textarea.rows = 3;
        
        const saveBtn = document.createElement('button');
        saveBtn.className = 'action-btn edit-save-btn';
        saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
        
        const cancelBtn = document.createElement('button');
        cancelBtn.className = 'action-btn edit-cancel-btn';
        cancelBtn.innerHTML = '<i class="fas fa-times"></i> Cancel';
        
        bodyEl.innerHTML = '';
        bodyEl.appendChild(textarea);
        bodyEl.appendChild(document.createElement('br'));
        bodyEl.appendChild(saveBtn);
        bodyEl.appendChild(cancelBtn);
        
        const saveHandler = () => {
            const newContent = textarea.value.trim();
            if (!newContent) {
                this.showError('Comment cannot be empty.');
                return;
            }
            
            fetch(`/comments/${commentId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: newContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bodyEl.innerHTML = this.escapeHtml(newContent);
                    this.showSuccess('Comment updated successfully!');
                } else {
                    this.showError(data.message || 'Failed to update comment.');
                }
            })
            .catch(error => console.error('Error updating comment:', error));
        };
        
        const cancelHandler = () => {
            bodyEl.innerHTML = this.escapeHtml(currentContent);
        };
        
        saveBtn.addEventListener('click', saveHandler);
        cancelBtn.addEventListener('click', cancelHandler);
        
        textarea.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                saveHandler();
            }
            if (e.key === 'Escape') {
                cancelHandler();
            }
        });
        
        textarea.focus();
        textarea.select();
    }

    // ===== DELETE FUNCTIONALITY =====
    deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) return;
        
        fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById(`comment-${commentId}`);
                if (el) {
                    el.remove();
                }
                const countEl = this.wrapper.querySelector('#commentCount');
                if (countEl) {
                    countEl.textContent = parseInt(countEl.textContent) - 1;
                }
                this.showSuccess('Comment deleted successfully!');
            } else {
                this.showError(data.message || 'Failed to delete comment.');
            }
        })
        .catch(error => console.error('Error deleting comment:', error));
    }

    // ===== SUBSCRIPTION =====
    toggleSubscribe() {
        const btn = this.wrapper.querySelector('#subscribeBtn');
        if (!btn) return;
        
        const isSubscribed = btn.classList.contains('active');
        const url = isSubscribed ? 'unsubscribe' : 'subscribe';
        
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        fetch(`/blogs/${this.blogId}/${url}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.success) {
                btn.classList.toggle('active');
                btn.innerHTML = isSubscribed ? 
                    '<i class="fas fa-bell"></i> Subscribe' : 
                    '<i class="fas fa-bell-slash"></i> Unsubscribe';
                this.showSuccess(data.message);
            }
        })
        .catch(error => {
            console.error('Error toggling subscription:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            this.showError('Failed to update subscription.');
        });
    }

    checkSubscriptionStatus() {
        const btn = this.wrapper.querySelector('#subscribeBtn');
        if (!btn || !this.userId) return;
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 5000);
        
        fetch(`/blogs/${this.blogId}/subscription-status`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: controller.signal
        })
        .then(response => {
            clearTimeout(timeoutId);
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.subscribed) {
                btn.classList.add('active');
                btn.innerHTML = '<i class="fas fa-bell-slash"></i> Unsubscribe';
            }
        })
        .catch(error => {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                console.log('Subscription status check timed out');
            } else {
                console.log('Subscription status check failed:', error.message);
            }
        });
    }

    // ===== UI HELPERS =====
    showLoading() {
        const list = this.wrapper.querySelector('#commentsList');
        if (this.currentPage === 1) {
            const loading = document.createElement('div');
            loading.id = 'loadingIndicator';
            loading.className = 'loading-spinner';
            loading.innerHTML = `
                <div class="spinner"></div>
                <p>Loading comments...</p>
            `;
            list.appendChild(loading);
        }
    }

    hideLoading() {
        const loading = document.getElementById('loadingIndicator');
        if (loading) loading.remove();
    }

    showEmptyState() {
        const list = this.wrapper.querySelector('#commentsList');
        list.innerHTML = `
            <div class="empty-state text-center py-5">
                <i class="fas fa-comment-dots"></i>
                <h5>No comments yet</h5>
                <p>Be the first to share your thoughts!</p>
            </div>
        `;
    }

    showError(message) {
        const errorEl = this.wrapper.querySelector('#commentError') || 
                       this.wrapper.querySelector('#guestCommentError');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
            setTimeout(() => {
                errorEl.style.display = 'none';
            }, 5000);
        }
    }

    showSuccess(message) {
        const successEl = this.wrapper.querySelector('#commentSuccess');
        if (successEl) {
            successEl.textContent = message;
            successEl.style.display = 'block';
            setTimeout(() => {
                successEl.style.display = 'none';
            }, 5000);
        }
    }

    clearErrors() {
        const errors = this.wrapper.querySelectorAll('.comment-error');
        errors.forEach(el => el.style.display = 'none');
    }
}

// ========================================
// GLOBAL FUNCTIONS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('comments-wrapper');
    if (wrapper) {
        console.log('Initializing CommentSystem...');
        window.commentSystem = new CommentSystem('comments-wrapper');
        console.log('CommentSystem initialized:', window.commentSystem);
    } else {
        console.error('Comments wrapper not found in DOM!');
    }
});

window.cancelComment = function() {
    if (window.commentSystem) {
        window.commentSystem.cancelComment();
    }
};

window.handleReplyClick = function(commentId, authorName, isGuest) {
    if (window.commentSystem) {
        window.commentSystem.handleReplyClick(commentId, authorName, isGuest);
    }
};

window.setReply = function(commentId, authorName) {
    if (window.commentSystem) {
        window.commentSystem.setReply(commentId, authorName);
    }
};

window.setGuestReply = function(commentId, authorName) {
    if (window.commentSystem) {
        window.commentSystem.setGuestReply(commentId, authorName);
    }
};

window.cancelReply = function() {
    if (window.commentSystem) {
        window.commentSystem.cancelReply();
    }
};

window.cancelGuestReply = function() {
    if (window.commentSystem) {
        window.commentSystem.cancelGuestReply();
    }
};

window.toggleLike = function(commentId) {
    if (window.commentSystem) {
        window.commentSystem.toggleLike(commentId);
    }
};

window.reportComment = function(commentId) {
    if (window.commentSystem) {
        window.commentSystem.reportComment(commentId);
    }
};

window.editComment = function(commentId) {
    if (window.commentSystem) {
        window.commentSystem.editComment(commentId);
    }
};

window.deleteComment = function(commentId) {
    if (window.commentSystem) {
        window.commentSystem.deleteComment(commentId);
    }
};

console.log('Comments.js loaded successfully!');