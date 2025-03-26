@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Edit Publication</h1>
     <!-- Back Button at Top Right -->
     <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
             <i class="fas fa-backward"></i> Back
          </a>
    <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Title Input -->
        <div class="mb-3">
            <label for="title" class="form-label" style="color: brown; font-weight: bold;">Publication Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $publication->title) }}" required>
        </div>
         <!-- File Upload Input (optional) -->
        <div class="mb-3">
            <label for="file" class="form-label" style="color: brown; font-weight: bold;">Select a New File (optional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <small class="form-text text-muted" style="color: green; font-weight: bold;">Leave blank to keep the current file.</small>
        </div>
        <!-- Current File Display (optional) -->
        <div class="mb-3">
            <p>Current File: <a href="{{ route('publications.download', $publication->id) }}" target="_blank">Download Current Publication</a></p>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Publication</button>
    </form>
</div>
@endsection
