@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gallery-viewer.css') }}">
<style>
    /* Download Dropdown Styles */
    .download-wrapper {
        position: relative;
        display: inline-block;
    }

    .download-dropdown {
        position: absolute;
        top: 45px;
        right: 0;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        padding: 8px 0;
        min-width: 220px;
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
        background: #800000 !important;
        color: white !important;
    }

    .download-dropdown .dropdown-item:hover i {
        color: white !important;
    }

    .download-dropdown .dropdown-item:hover .size-badge {
        background: rgba(255,255,255,0.3);
        color: white;
    }

    .download-dropdown .dropdown-item i {
        margin-right: 10px;
        color: #6c757d;
        width: 18px;
        transition: color 0.2s ease;
    }

    .download-dropdown .dropdown-item .size-badge {
        font-size: 10px;
        background: #e9ecef;
        color: #6c757d;
        padding: 2px 10px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease;
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

    .download-dropdown .dropdown-item.original .size-badge {
        background: #d4edda;
        color: #155724;
    }

    .download-dropdown .dropdown-item.original:hover {
        background: #800000 !important;
        color: white !important;
    }

    .download-dropdown .dropdown-item.original:hover i {
        color: white !important;
    }

    .download-dropdown .dropdown-item.original:hover .size-badge {
        background: rgba(255,255,255,0.3);
        color: white;
    }

    .download-dropdown .dropdown-item.loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .viewer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: rgba(0,0,0,0.8);
        color: white;
        flex-wrap: wrap;
        gap: 10px;
    }

    .viewer-header .text-center {
        flex: 1;
        text-align: center;
    }

    .viewer-header .text-center h5 {
        color: white;
		margin-top: 5px !important;
        margin: 0;
    }

    .viewer-header .text-center small {
        color: rgba(255,255,255,0.7);
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .btn-action i {
        font-size: 14px;
    }

    .btn-action.download-btn {
        background: #28a745;
    }

    .btn-action.download-btn:hover {
        background: #218838;
    }

    .btn-action.share-btn {
        background: #17a2b8;
    }

    .btn-action.share-btn:hover {
        background: #138496;
    }

    .btn-action.info-btn {
        background: #6c757d;
    }

    .btn-action.info-btn:hover {
        background: #5a6268;
    }

    /* Toast animation */
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
</style>
@endsection

@section('content')
<div class="viewer">

    <!-- ===========================
         HEADER
    ============================ -->
    <div class="viewer-header">
        <div>
            <a href="{{ route('gallery.show', $photo->event->slug) }}" class="btn btn-light">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="text-center">
            <h5 class="mb-1">{{ $photo->title ?: $photo->original_name }}</h5>
            <small class="text-light">{{ $photo->event->event_name }}</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn-action info-btn" data-bs-toggle="offcanvas" data-bs-target="#photoInfoCanvas">
                <i class="fa fa-info-circle"></i> Info
            </button>

            <!-- Download Button with Dropdown -->
            <div class="download-wrapper">
                <button class="btn-action download-btn" onclick="toggleDownloadDropdown()" title="Download">
                    <i class="fa fa-download"></i> 
                </button>
                <div class="download-dropdown" id="downloadDropdown">
                    <div class="dropdown-header">
                        <i class="fa fa-download"></i> Select Size
                    </div>
                    <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('thumbnail', this)">
                        <i class="fa fa-image"></i> Thumbnail
                        <span class="size-badge">300×200</span>
                    </a>
                    <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('small', this)">
                        <i class="fa fa-image"></i> Small
                        <span class="size-badge">800px</span>
                    </a>
                    <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('medium', this)">
                        <i class="fa fa-image"></i> Medium
                        <span class="size-badge">1400px</span>
                    </a>
                    <a href="#" class="dropdown-item" onclick="downloadPhotoWithSize('large', this)">
                        <i class="fa fa-image"></i> Large
                        <span class="size-badge">2200px</span>
                    </a>
                    <a href="#" class="dropdown-item original" onclick="downloadPhotoWithSize('original', this)">
                        <i class="fa fa-file-image-o"></i> Original
                        <span class="size-badge">Full Size</span>
                    </a>
                </div>
            </div>

            <button class="btn-action share-btn" onclick="sharePhoto()">
                <i class="fa fa-share-alt"></i> Share
            </button>
        </div>
    </div>

    <!-- ===========================
         TOOLBAR
    ============================ -->
    <div class="viewer-toolbar">
        <button id="zoomOut" class="btn btn-dark">
            <i class="fa fa-search-minus"></i>
        </button>
        <button id="zoomReset" class="btn btn-dark">100%</button>
        <button id="zoomIn" class="btn btn-dark">
            <i class="fa fa-search-plus"></i>
        </button>
    </div>

    <!-- ===========================
         IMAGE
    ============================ -->
    <div class="viewer-body">
        @if($previous)
            <a class="nav-left" href="{{ route('gallery.photo', $previous->slug) }}">❮</a>
        @endif

        <div id="imageWrapper" class="viewer-image">
            <img
                id="viewerImage"
                src="{{ asset($photo->large_path) }}"
                draggable="false"
                alt="{{ $photo->title }}">
        </div>

        @if($next)
            <a class="nav-right" href="{{ route('gallery.photo', $next->slug) }}">❯</a>
        @endif
    </div>

    <!-- ===========================
         FOOTER
    ============================ -->
    <div class="viewer-footer">
        <div class="row">
            <div class="col-md-3">
                <strong>Dimensions</strong>
                <br>
                {{ $photo->width }} × {{ $photo->height }}
            </div>
            <div class="col-md-3">
                <strong>File Size</strong>
                <br>
                {{ number_format($photo->file_size/1024/1024,2) }} MB
            </div>
            <div class="col-md-3">
                <strong>Downloads</strong>
                <br>
                <span id="downloadCount">{{ $photo->downloads }}</span>
            </div>
            <div class="col-md-3">
                <strong>Uploaded</strong>
                <br>
                {{ $photo->created_at->format('d M Y') }}
            </div>
        </div>
    </div>

</div>

<!-- =======================================
     PHOTO INFORMATION
======================================== -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="photoInfoCanvas">
    <div class="offcanvas-header">
        <h5>Photo Information</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <table class="table table-bordered">
            <tr>
                <th>Title</th>
                <td>{{ $photo->title ?: '-' }}</td>
            </tr>
            <tr>
                <th>Original Name</th>
                <td>{{ $photo->original_name }}</td>
            </tr>
            <tr>
                <th>Event</th>
                <td><a href="{{ route('gallery.show', $photo->event->slug) }}">{{ $photo->event->event_name }}</a></td>
            </tr>
            <tr>
                <th>Dimensions</th>
                <td>{{ $photo->width }} × {{ $photo->height }}</td>
            </tr>
            <tr>
                <th>File Type</th>
                <td>{{ $photo->mime_type }}</td>
            </tr>
            <tr>
                <th>Extension</th>
                <td>{{ strtoupper($photo->extension) }}</td>
            </tr>
            <tr>
                <th>File Size</th>
                <td>{{ number_format($photo->file_size/1024/1024,2) }} MB</td>
            </tr>
            <tr>
                <th>Downloads</th>
                <td><span id="downloadCountInfo">{{ $photo->downloads }}</span></td>
            </tr>
            <tr>
                <th>Uploaded</th>
                <td>{{ $photo->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td><code>{{ $photo->slug }}</code></td>
            </tr>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
const photoSlug = "{{ $photo->slug }}";
const downloadOptionsUrl = "{{ route('gallery.download.options', $photo->slug) }}";
const downloadRoute = "{{ route('gallery.download', [$photo->slug, 'SIZE']) }}";
const downloadRecordUrl = "{{ route('gallery.download.record', $photo->slug) }}";

// Toggle download dropdown
function toggleDownloadDropdown() {
    const dropdown = document.getElementById('downloadDropdown');
    const isOpen = dropdown.classList.contains('show');
    
    // Close all dropdowns
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

// Download photo with specific size
function downloadPhotoWithSize(size, btn) {
    const originalHtml = btn.innerHTML;
    btn.classList.add('loading');
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Downloading...';
    btn.disabled = true;
    
    const url = downloadRoute.replace('SIZE', size);
    
    // Close the dropdown
    const dropdown = document.getElementById('downloadDropdown');
    if (dropdown) {
        dropdown.classList.remove('show');
    }
    
    // Fetch the file - server will increment the count
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
        
        // Fetch the updated count from server
        fetchDownloadCount();
        showToast('Download started!', 'success');
    })
    .catch(error => {
        console.error('Download error:', error);
        showToast(error.message || 'Failed to download. Please try again.', 'error');
    })
    .finally(() => {
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            btn.classList.remove('loading');
        }, 1000);
    });
}

// Fetch download count from server
function fetchDownloadCount() {
    fetch(downloadRecordUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.downloads !== undefined) {
            document.getElementById('downloadCount').textContent = data.downloads;
            document.getElementById('downloadCountInfo').textContent = data.downloads;
        }
    })
    .catch(error => console.error('Error fetching download count:', error));
}

// Share photo
function sharePhoto() {
    const title = "{{ $photo->title ?: 'Photo' }}";
    const url = "{{ route('gallery.photo', $photo->slug) }}";
    
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Check out this photo!',
            url: url
        })
        .catch(error => {
            console.log('Share cancelled:', error);
            copyShareLink();
        });
    } else {
        copyShareLink();
    }
}

function copyShareLink() {
    const url = "{{ route('gallery.photo', $photo->slug) }}";
    
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

// Toast notification
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
    toast.style.animation = 'slideUp 0.3s ease';
    
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
</script>

<script src="{{ asset('js/gallery-viewer.js') }}"></script>
@endsection