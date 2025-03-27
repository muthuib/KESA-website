@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>{{ $activity->title }}</h2>

    <!-- Back Button at Top Right -->
    <a href="{{ route('activities.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <p>{{ $activity->description }}</p>

    <div class="card shadow mb-4">
        <div class="card-body text-center">
            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                <!-- Display Video -->
                <video id="activityVideo" width="100%" height="auto" controls>
                    <source src="{{ asset($activity->media) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="mt-3">
                    <a href="{{ asset($activity->media) }}" class="btn btn-outline-primary" download>
                        <i class="fas fa-download"></i> Download Video
                    </a>
                </div>
            @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                <!-- Display Image -->
                <img src="{{ asset($activity->media) }}" alt="Uploaded Image" class="img-fluid" style="max-width: 300px;">
            @endif

            <!-- YouTube Link Section -->
            @if($activity->youtube_link)
                <div class="mt-3">
                    <a href="{{ $activity->youtube_link }}" target="_blank" class="btn btn-outline-danger">
                        <i class="fab fa-youtube"></i> Watch on YouTube
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
