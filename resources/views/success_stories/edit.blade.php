@extends('layouts.app')

@section('title', 'Edit Success Story')

@section('styles')
<style>
    body { background-color: #f8f9fc; }
    .ck-editor__editable { min-height: 300px; }
    .img-thumbnail { max-width: 220px; height: auto; }
    .form-label strong { font-weight: 600; }
    .card { border-radius: 12px; }
    .form-section { margin-bottom: 1.5rem; }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Success Story</h2>
        <a href="{{ route('success_stories.index') }}" class="btn btn-outline-secondary">
            Back to List
        </a>
    </div>

    <div class="card shadow-sm p-4 bg-white">
        <form action="{{ route('success_stories.update', $success_story->id) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              id="editStoryForm">

            @csrf
            @method('PUT')

            <div class="form-section row g-3">
                <!-- Title -->
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" name="title" id="title" class="form-control" 
                               value="{{ old('title', $success_story->title) }}" required>
                        <label for="title"><strong>Title <span class="text-danger">*</span></strong></label>
                    </div>
                </div>

                <!-- Author -->
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" name="author" id="author" class="form-control" 
                               value="{{ old('author', $success_story->author) }}" required>
                        <label for="author"><strong>Author <span class="text-danger">*</span></strong></label>
                    </div>
                </div>

                <!-- Published Date -->
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="published_at" class="form-label"><strong>Published Date <span class="text-danger">*</span></strong></label>
                        <input type="date" name="published_at" id="published_at" class="form-control"
                               value="{{ old('published_at', $success_story->published_at ? $success_story->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                        <small class="text-muted">Select date for story publication</small>
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="col-md-6">
                    <label for="cover_image" class="form-label"><strong>Cover Image</strong></label>
                    @if($success_story->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset($success_story->cover_image) }}" 
                                 alt="Current Cover" 
                                 class="img-thumbnail rounded shadow-sm">
                            <small class="text-muted d-block mt-1">Current image</small>
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="cover_image" class="form-control" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">JPG, JPEG, or PNG only</small>
                </div>
            </div>

            <!-- Story Content -->
            <div class="form-section mt-4">
                <label for="body-editor" class="form-label"><strong>Story Content <span class="text-danger">*</span></strong></label>
                <textarea name="body" id="body-editor" class="form-control d-none">{{ old('body', $success_story->body) }}</textarea>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-paper-plane"></i> Update Story
                </button>
                <a href="{{ route('success_stories.index') }}" class="btn btn-secondary btn-sm mt-2">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('body-editor');
    let editor;

    ClassicEditor
        .create(textarea, {
            toolbar: [
                'heading', '|',
                'bold', 'italic', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', '|',
                'undo', 'redo'
            ]
        })
        .then(ed => {
            editor = ed;
            console.log('CKEditor loaded successfully');
            textarea.style.display = 'none';
        })
        .catch(err => {
            console.error('CKEditor failed to load:', err);
            alert('Rich text editor failed to load. Please try again.');
        });

    // Sync editor content before submitting
    const form = document.getElementById('editStoryForm');
    form.addEventListener('submit', function (e) {
        if (editor) {
            const content = editor.getData().trim();
            if (!content) {
                e.preventDefault();
                alert('Please write the success story content.');
                return;
            }
            textarea.value = content;
        }
    });
});
</script>
@endsection
