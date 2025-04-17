@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Upload Publication</h1>

    <!-- Back Button -->
    <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <form action="{{ route('publications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label" style="color: brown; font-weight: bold;">Publication Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter publication title" required>
        </div>

        <!-- Authors -->
        <div class="mb-3">
            <label for="authors" class="form-label" style="color: brown; font-weight: bold;">Author(s)</label>
            <input type="text" name="authors" id="authors" class="form-control" placeholder="Enter author name(s)">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label" style="color: brown; font-weight: bold;">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Provide a brief description (optional)"></textarea>
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="file" class="form-label" style="color: brown; font-weight: bold;">Select Publication File</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small class="form-text text-muted">Accepted file types: PDF, DOCX, etc.</small>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-success">Upload Publication</button>
    </form>
</div>
@endsection
