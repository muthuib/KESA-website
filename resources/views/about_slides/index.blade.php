@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px;">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
    </a>
    
    <h2 class="text-center mb-4">About Us Page Slides</h2>
    
    <div class="text-end mb-3">
        <a href="{{ route('about-slides.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Slide
        </a>
    </div>
    
    <div class="row">
        @forelse($slides as $slide)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset($slide->IMAGE_PATH) }}" class="card-img-top" alt="{{ $slide->CAPTION }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $slide->CAPTION }}</h5>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('about-slides.show', $slide->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('about-slides.edit', $slide->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('about-slides.destroy', $slide->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this slide?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No slides uploaded yet.</p>
        </div>
        @endforelse
    </div>
    
    <!-- Optional file display section -->
    <div class="mb-3">
        @if(isset($slide) && $slide->IMAGE_PATH)
        <div class="mt-2">
            @php
                $extension = pathinfo($slide->IMAGE_PATH, PATHINFO_EXTENSION);
            @endphp
            @if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif', 'svg']))
                <!-- Display image -->
                <img src="{{ asset($slide->IMAGE_PATH) }}" alt="Current IMAGE" width="40">
            @elseif ($extension === 'pdf')
                <!-- Display PDF link -->
                <a href="{{ asset($slide->IMAGE_PATH) }}" target="_blank">View PDF</a>
            @elseif (in_array($extension, ['mp4']))
                <!-- Display video -->
                <video width="320" height="240" controls>
                    <source src="{{ asset($slide->IMAGE_PATH) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <!-- Download link for other file types -->
                <a href="{{ asset($slide->IMAGE_PATH) }}" target="_blank">Download File</a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

<!-- Inline CSS for Styling and Animations -->
<style>
    .animated-line {
        height: 6px;
        background-color: brown;
        width: 0;
        animation: growLine 2s forwards;
        margin: 20px auto; /* Centers the line horizontally */
    }
    @keyframes growLine {
        from { width: 0; }
        to { width: 30%; }
    }
</style>
