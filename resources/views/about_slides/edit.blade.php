@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px;">
    <!-- Back Button -->
    <a href="{{ route('about-slides.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
    </a>
    <h2 class="text-center mb-4">Edit Slide</h2>
    <form action="{{ route('about-slides.update', $aboutSlide->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="slide_image" class="form-label">Slide Image</label>
            @if($aboutSlide->IMAGE_PATH)
                <div class="mb-2">
                    <img src="{{ asset($aboutSlide->IMAGE_PATH) }}" alt="{{ $aboutSlide->CAPTION }}" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="slide_image" id="slide_image" class="form-control">
            @error('slide_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Slide Caption</label>
            <input type="text" name="caption" id="caption" class="form-control" value="{{ old('caption', $aboutSlide->CAPTION) }}" required>
            @error('caption')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Slide</button>
    </form>
</div>
@endsection
