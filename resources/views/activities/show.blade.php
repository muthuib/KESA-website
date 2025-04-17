@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>{{ $activity->title }}</h2>

    <a href="{{ route('activities.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <div class="row mb-4">
        <div class="col-md-6">
            <strong>Venue:</strong> {{ $activity->location ?? '-' }}
        </div>
        <div class="col-md-6">
            <strong>Date:</strong> 
            {{ $activity->date ? \Carbon\Carbon::parse($activity->date)->format('F j, Y') : '-' }}<br>
            <strong>Start Time:</strong> 
            {{ $activity->start_time ? \Carbon\Carbon::parse($activity->start_time)->format('h:i A') : '-' }}<br>
            <strong>End Time:</strong> 
            {{ $activity->end_time ? \Carbon\Carbon::parse($activity->end_time)->format('h:i A') : '-' }}
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body text-center">
            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                <video width="100%" controls>
                    <source src="{{ asset($activity->media) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="mt-3">
                    <a href="{{ asset($activity->media) }}" class="btn btn-outline-primary" download>
                        <i class="fas fa-download"></i> Download Video
                    </a>
                </div>
            @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                <img src="{{ asset($activity->media) }}" alt="Uploaded Image" class="img-fluid mb-3" style="max-width: 300px;">
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
                <h5 class="mb-0"><i class="fas fa-images text-info"></i> More Images from the Event</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach (['media1', 'media2', 'media3'] as $img)
                        @if ($activity->$img)
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset($activity->$img) }}" alt="Additional Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="mb-4">
        <h5 class="mt-3"><i class="fas fa-align-left text-primary"></i> Description</h5>
        <div class="border p-3 rounded bg-light">
            {!! $activity->description !!}
        </div>
    </div>
</div>
@endsection
