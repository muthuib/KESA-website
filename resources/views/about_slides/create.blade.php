@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px;">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
            <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
        </a>
    <h2 class="text-center mb-4">Upload New Slide</h2>
    <form action="{{ route('about-slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="slide_image" class="form-label">Slide Image</label>
            <input type="file" name="slide_image" id="slide_image" class="form-control" required>
            @error('slide_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Slide Caption</label>
            <input type="text" name="caption" id="caption" class="form-control" placeholder="Enter slide caption" required>
            @error('caption')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Upload Slide</button>
    </form>
</div>
@endsection
