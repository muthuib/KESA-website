@extends('layouts.app')

@section('styles')
<style>
    .photo-credit {
        background: linear-gradient(135deg, rgba(128, 0, 0, 0.08), rgba(128, 0, 0, 0.02));
        border-left: 4px solid #800000;
        padding: 0.75rem 1rem;
        margin: 1rem 0 1.5rem 0;
        border-radius: 4px;
        font-size: 0.95rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .photo-credit i {
        color: #800000;
        font-size: 1.1rem;
    }
    
    .photo-credit .credit-label {
        color: #800000;
        font-weight: 500;
    }
    
    .photo-credit .credit-name {
        color: #333;
        font-weight: 600;
        font-style: italic;
    }
    
    .activity-title {
        color: #800000;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #800000;
    }
    
    .detail-item {
        padding: 0.5rem 0;
    }
    
    .detail-item strong {
        color: #2c3e50;
        min-width: 100px;
        display: inline-block;
    }
    
    .description-box {
        border-left: 4px solid #800000;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 4px;
        line-height: 1.8;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #800000;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .card-header h5 {
        color: #800000;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="activity-title">{{ $activity->title }}</h2>
        <a href="{{ route('activities.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="detail-item">
                <strong><i class="fas fa-map-pin text-danger"></i> Venue:</strong> 
                {{ $activity->location ?? '-' }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-item">
                <strong><i class="fas fa-calendar-day text-success"></i> Date:</strong> 
                {{ $activity->date ? \Carbon\Carbon::parse($activity->date)->format('F j, Y') : '-' }}
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-clock text-warning"></i> Start Time:</strong> 
                {{ $activity->start_time ? \Carbon\Carbon::parse($activity->start_time)->format('h:i A') : '-' }}
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-clock text-warning"></i> End Time:</strong> 
                {{ $activity->end_time ? \Carbon\Carbon::parse($activity->end_time)->format('h:i A') : '-' }}
            </div>
        </div>
    </div>
    
    <!-- Photo Credit -->
    @if($activity->photo_credit)
        <div class="photo-credit">
            <i class="fas fa-camera"></i>
            <span class="credit-label">Photo Credit:</span>
            <span class="credit-name">{{ $activity->photo_credit }}</span>
        </div>
    @endif

    <div class="mb-4">
        <h5 class="mt-3"><i class="fas fa-align-left" style="color: #800000;"></i> Description</h5>
        <div class="description-box">
            {!! $activity->description !!}
        </div>
    </div>
    
    <!-- Main Media -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-image" style="color: #800000;"></i> Event Media</h5>
        </div>
        <div class="card-body text-center">
            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                <video width="100%" controls style="max-width: 500px;">
                    <source src="{{ asset($activity->media) }}" type="video/mp4"> 
                    Your browser does not support the video tag.
                </video>
                <div class="mt-3">
                    <a href="{{ asset($activity->media) }}" class="btn btn-outline-primary" download>
                        <i class="fas fa-download"></i> Download Video
                    </a>
                </div>
            @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                <img src="{{ asset($activity->media) }}" alt="Uploaded Image" class="img-fluid mb-3" style="max-width: 500px; border-radius: 8px;">
            @endif

            @if($activity->youtube_link)
                <div class="mt-3">
                    <a href="{{ $activity->youtube_link }}" target="_blank" class="btn btn-outline-danger">
                        <i class="fab fa-youtube"></i> Watch on YouTube
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Additional Images Section --}}
    @if($activity->media1 || $activity->media2 || $activity->media3)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-images" style="color: #800000;"></i> More Images from the Event</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach (['media1', 'media2', 'media3'] as $img)
                        @if ($activity->$img)
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset($activity->$img) }}" alt="Additional Image" class="img-fluid rounded shadow" style="max-height: 300px; width: 100%; object-fit: cover;">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection