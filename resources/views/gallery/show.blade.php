@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gallery-show.css') }}">
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
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
                                    <span class="stat-value">
                                        <span class="date-range">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                            @if($event->event_end_date)
                                                <span class="date-separator">—</span>
                                                {{ \Carbon\Carbon::parse($event->event_end_date)->format('d M Y') }}
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            @if($event->start_time || $event->end_time)
                                <div class="stat-divider"></div>
                                <div class="stat-item">
                                    <div class="stat-icon-wrapper">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-label">Time</span>
                                        <span class="stat-value">
                                            @if($event->start_time && $event->end_time)
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                                <span class="date-separator">—</span>
                                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            @elseif($event->start_time)
                                                Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                            @elseif($event->end_time)
                                                Ends: {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                            
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
                            
                            @if($event->display_end_date)
                                <div class="stat-divider"></div>
                                <div class="stat-item">
                                    <div class="stat-icon-wrapper" style="background: rgba(13, 202, 240, 0.08); color: #0dcaf0;">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-label">Available Until</span>
                                        <span class="stat-value">{{ \Carbon\Carbon::parse($event->display_end_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            @endif
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
                                    <span class="stat-value">
                                        <span class="date-range">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                            @if($event->event_end_date)
                                                <span class="date-separator">—</span>
                                                {{ \Carbon\Carbon::parse($event->event_end_date)->format('d M Y') }}
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            @if($event->start_time || $event->end_time)
                                <div class="stat-divider"></div>
                                <div class="stat-item">
                                    <div class="stat-icon-wrapper">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-label">Time</span>
                                        <span class="stat-value">
                                            @if($event->start_time && $event->end_time)
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                                <span class="date-separator">—</span>
                                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            @elseif($event->start_time)
                                                Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                            @elseif($event->end_time)
                                                Ends: {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                            
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
                            
                            @if($event->display_end_date)
                                <div class="stat-divider"></div>
                                <div class="stat-item">
                                    <div class="stat-icon-wrapper" style="background: rgba(13, 202, 240, 0.08); color: #0dcaf0;">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-label">Display Until</span>
                                        <span class="stat-value">{{ \Carbon\Carbon::parse($event->display_end_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <div class="mini-stats">
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
    <div class="position-relative">
        <!-- Centered Content -->
        <div class="text-center w-100" style="margin-top: 10px; margin-bottom: 15px;">
            <h2 class="mb-1" style="font-weight: bold;">{{ $event->event_name }}</h2>
            <p class="text-muted mb-2">{{ $event->description }}</p>
            <small class="text-muted d-block">
                <strong>Date:</strong>
                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                @if($event->event_end_date)
                    <span class="date-separator">—</span>
                    {{ \Carbon\Carbon::parse($event->event_end_date)->format('d M Y') }}
                @endif
                &nbsp;&nbsp;&nbsp;
                @if($event->start_time || $event->end_time)
                    <strong>Time:</strong>
                    @if($event->start_time && $event->end_time)
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                        <span class="date-separator">—</span>
                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                    @elseif($event->start_time)
                        Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                    @elseif($event->end_time)
                        Ends: {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                    @endif
                    &nbsp;&nbsp;&nbsp;
                @endif
                <strong>Location:</strong>
                {{ $event->location }}
                &nbsp;&nbsp;&nbsp;
                <strong>Photos:</strong>
                {{ $event->photos_count ?? $photos->total() }}
                @if($event->display_end_date)
                    &nbsp;&nbsp;&nbsp;
                    <strong>Display Until:</strong>
                    {{ \Carbon\Carbon::parse($event->display_end_date)->format('d M Y') }}
                @endif
            </small>
        </div>
    </div>
@endauth

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    <div id="loadingSearch" class="text-center mb-3" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted mt-2">Searching...</p>
    </div>

    @if($photos->count())
        <div id="galleryContainer" class="gallery-grid">
            @include('gallery.partials.photos', ['photos' => $photos])
        </div>
        <div class="pagination-wrapper mt-5">
            <div class="maroon-theme">
                {{ $photos->links('pagination::bootstrap-5') }}
            </div>
        </div>
        
        <style>
        .maroon-theme .page-link {
            color: #800000 !important;
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
        </div>
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