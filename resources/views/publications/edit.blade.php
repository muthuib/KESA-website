@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Edit Publication</h1>

    <!-- Back Button -->
    <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Cover page -->
         <div class="mb-3">
                <label for="cover" class="form-label" style="color: brown; font-weight: bold;">Cover Image (optional)</label>
                <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
                @if($publication->cover_image)
                    <p class="mt-2">Current Cover: 
                        <img src="{{ asset($publication->cover_image) }}" alt="Cover" style="width: 100px; height: auto; border-radius: 5px;">
                    </p>
                @endif
            </div>

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label" style="color: brown; font-weight: bold;">Publication Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $publication->title) }}" required>
        </div>

        <!-- Authors -->
        <div class="mb-3">
            <label for="authors" class="form-label" style="color: brown; font-weight: bold;">Author(s)</label>
            <input type="text" name="authors" id="authors" class="form-control" value="{{ old('authors', $publication->authors) }}">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label" style="color: brown; font-weight: bold;">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $publication->description) }}</textarea>
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="file" class="form-label" style="color: brown; font-weight: bold;">Select a New File (optional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <small class="form-text text-muted" style="color: green; font-weight: bold;">Leave blank to keep the current file.</small>
        </div>

        <!-- Current File -->
        <div class="mb-3">
            <p>Current File: <a href="{{ route('publications.download', $publication->id) }}" target="_blank">Download Current Publication</a></p>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Update Publication</button>
    </form>
</div>
@endsection
