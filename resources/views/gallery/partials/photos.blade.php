@foreach($photos as $photo)
    <div class="gallery-item-wrapper">
        <div class="gallery-item" data-photo-id="{{ $photo->id }}" data-photo-slug="{{ $photo->slug }}">
            @php
                // Try to find the best available image
                $imageUrl = null;
                $sizes = ['small_path', 'medium_path', 'thumbnail_path', 'original_path'];
                
                foreach ($sizes as $size) {
                    if (!empty($photo->$size)) {
                        $fullPath = public_path($photo->$size);
                        if (File::exists($fullPath)) {
                            $imageUrl = asset($photo->$size);
                            break;
                        }
                    }
                }
                
                // Get download URLs for different sizes using slugs
                $downloadUrls = [
                    'thumbnail' => route('gallery.download', [$photo->slug, 'thumbnail']),
                    'small' => route('gallery.download', [$photo->slug, 'small']),
                    'medium' => route('gallery.download', [$photo->slug, 'medium']),
                    'large' => route('gallery.download', [$photo->slug, 'large']),
                    'original' => route('gallery.download', [$photo->slug, 'original'])
                ];
            @endphp
            
            @if($imageUrl)
                <img 
                    src="{{ $imageUrl }}" 
                    alt="{{ $photo->title ?? 'Photo' }}"
                    loading="lazy"
                    onerror="this.style.display='none'; this.parentElement.querySelector('.no-image-placeholder').style.display='flex';">
            @endif
            
            <!-- Delete Photo Button - Admin Only -->
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <button class="btn-delete-photo" onclick="event.stopPropagation(); confirmDeletePhoto('{{ $photo->slug }}')" title="Delete Photo">
                        <i class="fa fa-trash"></i>
                    </button>
                @endif
            @endauth
            
            <!-- Fallback placeholder -->
            <div class="no-image-placeholder" style="{{ $imageUrl ? 'display:none;' : '' }}">
                <i class="fa fa-image"></i>
                <span>No Image</span>
            </div>
            
            <!-- Overlay with buttons -->
            <div class="overlay">
                <div class="overlay-content">
                    <p class="title">{{ $photo->title ?? 'Untitled' }}</p>
                    <p class="meta">
                        <i class="fa fa-download"></i> <span class="download-count">{{ $photo->downloads ?? 0 }}</span>
                        &nbsp;
                        <i class="fa fa-calendar"></i> {{ $photo->created_at ? $photo->created_at->format('d M Y') : '' }}
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn-action view-btn" onclick="viewPhoto('{{ $photo->slug }}')" title="View Photo">
                        <i class="fa fa-eye"></i>
                    </button>
                    
                    <!-- Download Button with Dropdown -->
                    <div class="download-wrapper">
                        <button class="btn-action download-btn" onclick="toggleDownloadDropdown('{{ $photo->slug }}')" title="Download">
                            <i class="fa fa-download"></i>
                        </button>
                        <div class="download-dropdown" id="downloadDropdown{{ $photo->slug }}">
                            <div class="dropdown-header">Select Size</div>
                            <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('{{ $photo->slug }}', 'thumbnail', this)">
                                <i class="fa fa-image"></i> Thumbnail
                                <span class="size-badge">Small</span>
                            </a>
                            <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('{{ $photo->slug }}', 'small', this)">
                                <i class="fa fa-image"></i> Small
                                <span class="size-badge">800px</span>
                            </a>
                            <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('{{ $photo->slug }}', 'medium', this)">
                                <i class="fa fa-image"></i> Medium
                                <span class="size-badge">1400px</span>
                            </a>
                            <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('{{ $photo->slug }}', 'large', this)">
                                <i class="fa fa-image"></i> Large
                                <span class="size-badge">2200px</span>
                            </a>
                            <a href="#" class="dropdown-item original" onclick="downloadPhotoWithSize('{{ $photo->slug }}', 'original', this)">
                                <i class="fa fa-file-image-o"></i> Original
                                <span class="size-badge">Full</span>
                            </a>
                        </div>
                    </div>
                    
                    <button class="btn-action share-btn" onclick="sharePhoto('{{ $photo->title ?? 'Photo' }}', '{{ $imageUrl }}', '{{ $photo->slug }}')" title="Share Photo">
                        <i class="fa fa-share-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@if($photos->isEmpty())
    <div class="col-12 text-center py-5">
        <i class="fa fa-image fa-3x text-muted mb-3"></i>
        <p class="text-muted">No photos found matching your search.</p>
    </div>
@endif

<!-- Add JavaScript for actions -->
<script>
function viewPhoto(slug) {
    window.location.href = "{{ url('/photo-gallery/photo') }}/" + slug;
}

function toggleDownloadDropdown(slug) {
    const dropdown = document.getElementById('downloadDropdown' + slug);
    const isOpen = dropdown.classList.contains('show');
    
    // Close all dropdowns first
    document.querySelectorAll('.download-dropdown').forEach(el => {
        el.classList.remove('show');
    });
    
    // Toggle this dropdown
    if (!isOpen) {
        dropdown.classList.add('show');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.download-wrapper')) {
        document.querySelectorAll('.download-dropdown').forEach(el => {
            el.classList.remove('show');
        });
    }
});

function downloadPhotoWithSize(slug, size, btn) {
    // Show loading
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Downloading...';
    btn.disabled = true;
    
    const url = "{{ url('/photo-gallery/download') }}/" + slug + "/" + size;
    
    // Close the dropdown
    const dropdown = document.getElementById('downloadDropdown' + slug);
    if (dropdown) {
        dropdown.classList.remove('show');
    }
    
    // Fetch the file
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { 
                throw new Error(err.error || 'Download failed'); 
            });
        }
        return response.blob();
    })
    .then(blob => {
        // Create download link
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'photo_' + size + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
        
        // Update download count in UI only - server already recorded it
        updateDownloadCountUI(slug);
        showToast('Download started!', 'success');
    })
    .catch(error => {
        console.error('Download error:', error);
        showToast(error.message || 'Failed to download. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        }, 1000);
    });
}

function sharePhoto(title, imageUrl, slug) {
    const url = "{{ url('/photo-gallery/photo') }}/" + slug;
    
    if (navigator.share) {
        navigator.share({
            title: title || 'Photo',
            text: 'Check out this photo!',
            url: url
        })
        .catch(error => {
            console.log('Share cancelled:', error);
            copyShareLink(slug);
        });
    } else {
        copyShareLink(slug);
    }
}

function copyShareLink(slug) {
    const url = "{{ url('/photo-gallery/photo') }}/" + slug;
    
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url)
            .then(() => {
                showToast('Link copied to clipboard!', 'success');
            })
            .catch(() => {
                fallbackCopyLink(url);
            });
    } else {
        fallbackCopyLink(url);
    }
}

function fallbackCopyLink(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    
    try {
        document.execCommand('copy');
        showToast('Link copied to clipboard!', 'success');
    } catch (err) {
        showToast('Failed to copy link. Please copy it manually.', 'error');
    }
    
    document.body.removeChild(textarea);
}

// Update download count in UI only (no server call)
function updateDownloadCountUI(slug) {
    const metaElement = document.querySelector(`.gallery-item[data-photo-slug="${slug}"] .meta`);
    if (metaElement) {
        const countElement = metaElement.querySelector('.download-count');
        if (countElement) {
            const currentCount = parseInt(countElement.textContent) || 0;
            countElement.textContent = currentCount + 1;
        }
    }
}

// Delete Photo Function
function confirmDeletePhoto(photoSlug) {
    if (confirm('Are you sure you want to delete this photo? This action cannot be undone.')) {
        // Remove /delete from the URL - just use the photo slug URL
        const url = "{{ url('/photo-gallery/photo') }}/" + photoSlug;
        
        // Show loading state on the button
        const btn = document.querySelector(`.btn-delete-photo[onclick*="${photoSlug}"]`);
        if (btn) {
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            btn.disabled = true;
        }
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Photo deleted successfully!', 'success');
                // Remove the photo from the DOM
                const photoElement = document.querySelector(`.gallery-item[data-photo-slug="${photoSlug}"]`);
                if (photoElement) {
                    const wrapper = photoElement.closest('.gallery-item-wrapper');
                    if (wrapper) {
                        wrapper.style.transition = 'all 0.3s ease';
                        wrapper.style.transform = 'scale(0.8)';
                        wrapper.style.opacity = '0';
                        setTimeout(() => {
                            wrapper.remove();
                            updatePhotoCount();
                        }, 300);
                    }
                }
            } else {
                showToast(data.message || 'Failed to delete photo', 'error');
                if (btn) {
                    btn.innerHTML = '<i class="fa fa-trash"></i>';
                    btn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showToast('Failed to delete photo. Please try again.', 'error');
            if (btn) {
                btn.innerHTML = '<i class="fa fa-trash"></i>';
                btn.disabled = false;
            }
        });
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast-message toast-${type}`;
    toast.innerHTML = message;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.padding = '12px 24px';
    toast.style.borderRadius = '8px';
    toast.style.zIndex = '9999';
    toast.style.color = 'white';
    toast.style.fontSize = '14px';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    
    if (type === 'success') {
        toast.style.background = '#28a745';
    } else if (type === 'error') {
        toast.style.background = '#dc3545';
    } else {
        toast.style.background = '#17a2b8';
    }
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Close delete modal if it exists in the parent
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('deletePhotoModal');
        if (modal && modal.classList.contains('active')) {
            modal.classList.remove('active');
        }
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('deletePhotoModal');
    if (modal && modal.classList.contains('active') && e.target === modal) {
        modal.classList.remove('active');
    }
});
</script>

<!-- Updated Styles -->
<style>
.toast-message {
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
}

/* Gallery item wrapper */
.gallery-item-wrapper {
    position: relative;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    background: #f8f9fa;
    aspect-ratio: 1 / 1;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    text-decoration: none;
    display: block;
}

.gallery-item:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    z-index: 2;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-item .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px 12px 12px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .overlay {
    opacity: 1;
}

.gallery-item .overlay .overlay-content {
    margin-bottom: 8px;
}

.gallery-item .overlay .title {
    color: white;
    font-size: 13px;
    font-weight: 500;
    margin: 0;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.gallery-item .overlay .meta {
    color: rgba(255,255,255,0.8);
    font-size: 11px;
    margin: 4px 0 0;
}

.gallery-item .action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    position: relative;
}

.gallery-item .action-buttons .btn-action {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.2);
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    backdrop-filter: blur(4px);
}

.gallery-item .action-buttons .btn-action:hover {
    background: rgba(255,255,255,0.4);
    transform: scale(1.1);
}

.gallery-item .action-buttons .btn-action:active {
    transform: scale(0.95);
}

.gallery-item .action-buttons .btn-action.download-btn:hover {
    background: rgba(40, 167, 69, 0.8);
}

.gallery-item .action-buttons .btn-action.share-btn:hover {
    background: rgba(23, 162, 184, 0.8);
}

.gallery-item .action-buttons .btn-action.view-btn:hover {
    background: rgba(0, 123, 255, 0.8);
}

/* Delete Photo Button */
.btn-delete-photo {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
    background: rgba(220, 53, 69, 0.9);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0;
    backdrop-filter: blur(4px);
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

.gallery-item:hover .btn-delete-photo {
    opacity: 1;
}

.btn-delete-photo:hover {
    background: #dc3545;
    transform: scale(1.1);
    box-shadow: 0 4px 16px rgba(220, 53, 69, 0.5);
}

.btn-delete-photo i {
    font-size: 14px;
}

/* Download wrapper - positions the dropdown */
.download-wrapper {
    position: relative;
    display: inline-block;
}

/* Download Dropdown */
.download-dropdown {
    position: absolute;
    bottom: 40px;
    right: 0;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    padding: 8px 0;
    min-width: 200px;
    display: none;
    z-index: 1000;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.2s ease;
}

.download-dropdown.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.download-dropdown .dropdown-header {
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 600;
    color: #6c757d;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.download-dropdown .dropdown-item {
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    transition: background 0.2s ease;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.download-dropdown .dropdown-item:hover {
    background: #f8f9fa;
}

.download-dropdown .dropdown-item i {
    margin-right: 10px;
    color: #6c757d;
    width: 16px;
}

.download-dropdown .dropdown-item .size-badge {
    font-size: 10px;
    background: #e9ecef;
    color: #6c757d;
    padding: 2px 8px;
    border-radius: 10px;
}

.download-dropdown .dropdown-item.original {
    border-top: 1px solid #e9ecef;
    margin-top: 4px;
    padding-top: 10px;
    color: #28a745;
}

.download-dropdown .dropdown-item.original i {
    color: #28a745;
}

.no-image-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    background: #e9ecef;
    color: #adb5bd;
}

.no-image-placeholder i {
    font-size: 48px;
    margin-bottom: 8px;
}

.no-image-placeholder span {
    font-size: 13px;
}

/* Responsive for delete button */
@media (max-width: 768px) {
    .btn-delete-photo {
        width: 28px;
        height: 28px;
        font-size: 12px;
        top: 6px;
        left: 6px;
    }
}

@media (max-width: 480px) {
    .btn-delete-photo {
        width: 24px;
        height: 24px;
        font-size: 10px;
        top: 4px;
        left: 4px;
    }
}
</style>