@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Add Past Event</h2>

    <a href="{{ route('activities.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10;">
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

    <form id="activity-form" action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Event Title *</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Venue</label>
            <input type="text" id="location" name="location" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" name="date" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" id="start_time" name="start_time" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" id="end_time" name="end_time" class="form-control">
            </div>
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
            <div id="quill-editor" style="height: 300px;"></div>
            <input type="hidden" name="description" id="description">
        </div>
        <!-- Media Fields (media1, media2, media3) -->
         <p style="color:brown; font-weight: bold;">Add additional event images</p>
        <div class="mb-3">
            <label for="media1" class="form-label">Upload Additional Image 1 (Optional)</label>
            <input type="file" id="media1" name="media1" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="media2" class="form-label">Upload Additional Image 2 (Optional)</label>
            <input type="file" id="media2" name="media2" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="media3" class="form-label">Upload Additional Image 3 (Optional)</label>
            <input type="file" id="media3" name="media3" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Add Event
        </button>
    </form>
</div>

<!-- Quill JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write event description...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Ensure hidden input gets Quill content before form submission
        document.getElementById('activity-form').addEventListener('submit', function () {
            document.getElementById('description').value = quill.root.innerHTML;
        });

        // Add validation to restrict image uploads to a maximum of 4
        document.getElementById('activity-form').addEventListener('submit', function (e) {
            const imageInputs = [document.getElementById('media'), document.getElementById('media1'), document.getElementById('media2'), document.getElementById('media3')];
            const totalFiles = imageInputs.reduce((total, input) => total + input.files.length, 0);

            if (totalFiles > 4) {
                e.preventDefault();
                alert('You can upload a maximum of 3 images.');
            }
        });
    });
</script>
@endsection
