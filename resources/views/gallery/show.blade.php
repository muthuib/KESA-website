@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gallery-show.css') }}">
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
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
        padding: 30px 12px 12px;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item:hover .overlay {
        opacity: 1;
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
    
    .gallery-item .image-count-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        backdrop-filter: blur(4px);
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
    
    /* Loading */
    #loadingSearch {
        padding: 40px 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
        }
    }
    
    @media (max-width: 480px) {
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
@section('content')
<div class="container-fluid py-4">

@auth
    @if(auth()->user()->hasRole('admin'))
        <!-- Admin Event Header -->
        <div class="card shadow-sm mb-4 gallery-header-card">
            <div class="card-body position-relative overflow-hidden">
                <!-- Animated Background -->
                <div class="header-bg-animation">
                    <div class="gradient-orb orb-1"></div>
                    <div class="gradient-orb orb-2"></div>
                    <div class="gradient-orb orb-3"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap position-relative" style="z-index:2;">
                    <div class="header-content">
                        <!-- Event Name -->
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="event-icon-wrapper">
                                <i class="fa fa-calendar-check-o event-icon"></i>
                            </div>
                            <h2 class="mb-0 event-title">{{ $event->event_name }}</h2>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-muted mb-2 event-description">
                            <i class="fa fa-quote-left text-primary opacity-50 me-1"></i>
                            {{ $event->description }}
                            <i class="fa fa-quote-right text-primary opacity-50 ms-1"></i>
                        </p>
                        
                        <!-- Stats -->
                        <div class="event-stats">
                            <div class="stat-item">
                                <div class="stat-icon-wrapper">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Date</span>
                                    <span class="stat-value">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-divider"></div>
                            
                            <div class="stat-item">
                                <div class="stat-icon-wrapper">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Location</span>
                                    <span class="stat-value">{{ $event->location }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-divider"></div>
                            
                            <div class="stat-item">
                                <div class="stat-icon-wrapper photo-count-icon">
                                    <i class="fa fa-image"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Photos</span>
                                    <span class="stat-value photo-count">
                                        {{ $event->photos_count ?? $photos->total() }}
                                        <span class="photo-count-badge">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin Actions -->
                    <div class="header-actions">
                        <a href="{{ route('gallery.upload.page', $event->slug) }}" class="btn btn-primary btn-upload">
                            <span class="btn-content">
                                <i class="fa fa-upload btn-icon"></i>
                                <span class="btn-text">Upload Photos</span>
                            </span>
                            <span class="btn-pulse"></span>
                        </a>
                        
                        <div class="mini-stats">
                            <!-- <span class="mini-stat">
                                <i class="fa fa-eye text-primary"></i>
                                <span class="mini-stat-value" id="viewCount">0</span>
                            </span> -->
                            <span class="mini-stat">
                                <i class="fa fa-download text-success"></i>Total Downloads
                                <span class="mini-stat-value" id="downloadCountHeader">{{ $event->photos->sum('downloads') ?? 0 }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Regular User / Admin without admin role -->
        <div class="card shadow-sm mb-4 gallery-header-card">
            <!-- Same header without upload button -->
            <div class="card-body position-relative overflow-hidden">
                <div class="header-bg-animation">
                    <div class="gradient-orb orb-1"></div>
                    <div class="gradient-orb orb-2"></div>
                    <div class="gradient-orb orb-3"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap position-relative" style="z-index:2;">
                    <div class="header-content">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="event-icon-wrapper">
                                <i class="fa fa-calendar-check-o event-icon"></i>
                            </div>
                            <h2 class="mb-0 event-title">{{ $event->event_name }}</h2>
                        </div>
                        
                        <p class="text-muted mb-2 event-description">
                            <i class="fa fa-quote-left text-primary opacity-50 me-1"></i>
                            {{ $event->description }}
                            <i class="fa fa-quote-right text-primary opacity-50 ms-1"></i>
                        </p>
                        
                        <div class="event-stats">
                            <div class="stat-item">
                                <div class="stat-icon-wrapper">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Date</span>
                                    <span class="stat-value">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-divider"></div>
                            
                            <div class="stat-item">
                                <div class="stat-icon-wrapper">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Location</span>
                                    <span class="stat-value">{{ $event->location }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-divider"></div>
                            
                            <div class="stat-item">
                                <div class="stat-icon-wrapper photo-count-icon">
                                    <i class="fa fa-image"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Photos</span>
                                    <span class="stat-value photo-count">
                                        {{ $event->photos_count ?? $photos->total() }}
                                        <span class="photo-count-badge">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <div class="mini-stats">
                            <!-- <span class="mini-stat">
                                <i class="fa fa-eye text-primary"></i>
                                <span class="mini-stat-value" id="viewCount">0</span>
                            </span> -->
                            <span class="mini-stat">
                                <i class="fa fa-download text-success"></i> Total Downloads
                                <span class="mini-stat-value" id="downloadCountHeader">{{ $event->photos->sum('downloads') ?? 0 }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <!-- Guest Header -->
   <!-- <div class="card shadow-sm mb-4"> -->
    <!-- <div class="card-body"> -->
		<div class="position-relative">
		    <!-- Badges - Top Right -->
		    <div class="position-absolute top-0 end-0">
		        <!-- <span class="badge bg-secondary">
		            <i class="fa fa-eye"></i> 0
		        </span> -->
		        <!-- <span class="badge bg-success ms-2">
		            <i class="fa fa-download"></i> {{ $event->photos->sum('downloads') ?? 0 }}
		        </span> -->
		    </div>
		    
		    <!-- Centered Content -->
		    <div class="text-center w-100" style="margin-top: -10px; margin-bottom: 15px;">
		        <h2 class="mb-1" style="font-weight: bold;">{{ $event->event_name }}</h2>
		        <p class="text-muted mb-2">{{ $event->description }}</p>
		        <small class="text-muted d-block">
		            <strong>Date:</strong>
		            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
		            &nbsp;&nbsp;&nbsp;
		            <strong>Location:</strong>
		            {{ $event->location }}
		            &nbsp;&nbsp;&nbsp;
		            <strong>Photos:</strong>
		            {{ $event->photos_count ?? $photos->total() }}
		        </small>
		    </div>
		</div>
    <!-- </div> -->
<!-- </div> -->
@endauth

<!-- Add this JavaScript for auto-view counter animation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate view count (optional - you can replace with actual view tracking)
    const viewCountEl = document.getElementById('viewCount');
    if (viewCountEl) {
        let count = 0;
        const target = Math.floor(Math.random() * 100) + 50;
        const interval = setInterval(() => {
            count += Math.floor(Math.random() * 3) + 1;
            if (count >= target) {
                count = target;
                clearInterval(interval);
            }
            viewCountEl.textContent = count;
        }, 50);
    }
});
</script>

    <!-- Search -->
    <!-- <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
                <input
                    id="searchBox"
                    type="text"
                    class="form-control"
                    placeholder="Search title or filename...">
                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div> -->

    <!-- Loading -->
    <div id="loadingSearch" class="text-center mb-3" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted mt-2">Searching...</p>
    </div>

    <!-- Gallery -->
    @if($photos->count())
        <div id="galleryContainer" class="gallery-grid">
            @include('gallery.partials.photos', ['photos' => $photos])
        </div>
      <!-- Pagination -->
       <div class="pagination-wrapper mt-5">
		    <div class="maroon-theme">
		        {{ $photos->links('pagination::bootstrap-5') }}
		    </div>
		</div>
		
		<style>
		.maroon-theme .page-link {
		    color: #800000 !important;
		    /* border-color: #800000 !important; */
		}
		.maroon-theme .page-link:hover {
		    background-color: #800000 !important;
		    color: #fff !important;
		}
		.maroon-theme .page-item.active .page-link {
		    background-color: #800000 !important;
		    border-color: #800000 !important;
		    color: #fff !important;
		}
		.maroon-theme .page-item.disabled .page-link {
		    color: #b88686 !important;
		}
		</style>
    @else
        <div class="text-center py-5">
            <i class="fa fa-images fa-4x text-muted mb-3"></i>
            <h4>No Photos Uploaded Yet</h4>
            <!-- <p class="text-muted">Upload photos to start building your gallery.</p>
            <a href="{{ route('gallery.upload.page', $event->slug) }}" class="btn btn-primary">
                <i class="fa fa-upload"></i> Upload Photos
            </a>
        </div> -->
    @endif

</div>
@endsection

@section('scripts')
<script>
    const gallerySearchUrl = "{{ route('gallery.search', $event->slug) }}";
    const galleryPhotoUrl = "{{ url('/photo-gallery/photo') }}";
</script>
<script src="{{ asset('js/gallery-show.js') }}"></script>
@endsection


<style>
.gallery-header-card {
    position: relative;
    border: none !important;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%) !important;
    border-radius: 20px !important;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.05) !important;
    transition: all 0.3s ease;
}

.gallery-header-card:hover {
    box-shadow: 0 20px 60px rgba(0,0,0,0.12), 0 5px 20px rgba(0,0,0,0.08) !important;
    transform: translateY(-2px);
}

/* Animated Background */
.header-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    z-index: 1;
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.15;
    animation: floatOrb 8s ease-in-out infinite;
}

.orb-1 {
    width: 300px;
    height: 300px;
    background: #0d6efd;
    top: -100px;
    right: -100px;
    animation-delay: 0s;
}

.orb-2 {
    width: 200px;
    height: 200px;
    background: #6f42c1;
    bottom: -50px;
    left: 20%;
    animation-delay: -3s;
}

.orb-3 {
    width: 250px;
    height: 250px;
    background: #0dcaf0;
    top: 50%;
    right: 20%;
    animation-delay: -5s;
}

@keyframes floatOrb {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    25% {
        transform: translate(30px, -20px) scale(1.05);
    }
    50% {
        transform: translate(-20px, 30px) scale(0.95);
    }
    75% {
        transform: translate(20px, 15px) scale(1.02);
    }
}

/* Event Icon */
.event-icon-wrapper {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0d6efd, #6f42c1);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    animation: pulseIcon 2s ease-in-out infinite;
    flex-shrink: 0;
}

.event-icon {
    color: white;
    font-size: 22px;
}

@keyframes pulseIcon {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 25px rgba(13, 110, 253, 0.4);
    }
}

.event-title {
    font-weight: 700;
    font-size: 28px;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
}

.event-description {
    font-size: 15px;
    color: #6c757d !important;
    padding-left: 8px;
    max-width: 600px;
    animation: fadeInUp 0.8s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stats */
.event-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 12px 24px;
    margin-top: 16px;
    padding: 16px 20px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.8);
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    max-width: 100%;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    cursor: default;
}

.stat-item:hover {
    transform: translateY(-2px);
}

.stat-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
    font-size: 16px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.stat-item:hover .stat-icon-wrapper {
    background: rgba(13, 110, 253, 0.15);
    transform: scale(1.05);
}

.stat-icon-wrapper.photo-count-icon {
    background: rgba(40, 167, 69, 0.08);
    color: #28a745;
}

.stat-item:hover .stat-icon-wrapper.photo-count-icon {
    background: rgba(40, 167, 69, 0.15);
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #adb5bd;
    font-weight: 600;
}

.stat-value {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
}

.stat-value.photo-count {
    display: flex;
    align-items: center;
    gap: 6px;
}

.photo-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 6px;
    font-size: 9px;
    animation: bounceBadge 2s ease-in-out infinite;
}

@keyframes bounceBadge {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.stat-divider {
    width: 1px;
    background: linear-gradient(to bottom, transparent, #e9ecef, transparent);
}

/* Upload Button */
.header-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
}

.btn-upload {
    position: relative;
    padding: 12px 28px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd, #6f42c1) !important;
    border: none !important;
    font-weight: 600;
    box-shadow: 0 4px 20px rgba(13, 110, 253, 0.3);
    transition: all 0.3s ease;
    overflow: hidden;
}

.btn-upload:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(13, 110, 253, 0.4);
}

.btn-upload:active {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
}

.btn-content {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    z-index: 2;
}

.btn-icon {
    font-size: 18px;
    animation: floatIcon 3s ease-in-out infinite;
}

@keyframes floatIcon {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-3px);
    }
}

.btn-text {
    font-size: 15px;
    letter-spacing: 0.3px;
}

.btn-pulse {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    transform: translate(-50%, -50%) scale(0);
    animation: pulseRing 2s ease-in-out infinite;
    pointer-events: none;
}

@keyframes pulseRing {
    0% {
        transform: translate(-50%, -50%) scale(0);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(2);
        opacity: 0;
    }
}

/* Mini Stats */
.mini-stats {
    display: flex;
    gap: 16px;
    padding: 6px 16px;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.8);
}

.mini-stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6c757d;
}

.mini-stat i {
    font-size: 13px;
}

.mini-stat-value {
    font-weight: 600;
    color: #1a1a2e;
}

/* Responsive */
@media (max-width: 992px) {
    .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 16px;
    }
    
    .header-actions {
        width: 100%;
        align-items: flex-start;
    }
    
    .btn-upload {
        width: 100%;
        justify-content: center;
    }
    
    .mini-stats {
        width: 100%;
        justify-content: center;
    }
    
    .event-stats {
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }
    
    .stat-divider {
        display: none;
    }
    
    .event-title {
        font-size: 22px;
    }
}

@media (max-width: 576px) {
    .event-icon-wrapper {
        width: 40px;
        height: 40px;
    }
    
    .event-icon {
        font-size: 18px;
    }
    
    .event-title {
        font-size: 18px;
    }
    
    .event-stats {
        padding: 12px 16px;
    }
    
    .stat-item {
        gap: 8px;
    }
    
    .stat-icon-wrapper {
        width: 30px;
        height: 30px;
        font-size: 13px;
    }
    
    .stat-value {
        font-size: 12px;
    }
}
</style>