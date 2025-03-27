@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Add Past Event</h2>
    
    <!-- Back Button at Top Right -->
    <a href="{{ route('activities.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Event Title *</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="media" class="form-label">Upload Video/Image *</label>
            <input type="file" id="media" name="media" class="form-control" accept="video/*,image/*" required>
        </div>

        <div class="mb-3">
            <label for="youtube_link" class="form-label">YouTube Link (Optional)</label>
            <input type="url" id="youtube_link" name="youtube_link" class="form-control" placeholder="https://www.youtube.com/watch?v=example">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Add Event
        </button>
    </form>
</div>
@endsection
