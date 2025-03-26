@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Upload Publication</h1>
     <!-- Back Button at Top Right -->
     <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
             <i class="fas fa-backward"></i> Back
          </a>
    <form action="{{ route('publications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Title Input -->
        <div class="mb-3">
            <label for="title" class="form-label" style="color: brown; font-weight: bold;">Publication Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter publication title" required>
        </div>
        <!-- File Upload Input -->
        <div class="mb-3">
            <label for="file" class="form-label" style="color: brown; font-weight: bold;">Select Publication File</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small class="form-text text-muted">Accepted file types: PDF, DOCX, etc.</small>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Upload Publication</button>
    </form>
</div>
@endsection
