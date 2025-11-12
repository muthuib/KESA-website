@extends('layouts.app')

@section('title', 'Add Success Story')

@section('styles')
<style>
    .ck-editor__editable { min-height: 300px; }
    .form-label, .form-floating label { font-size: 0.875rem; }
    .form-control, .form-select { font-size: 0.875rem; padding: 0.375rem 0.75rem; height: calc(1.5em + 0.75rem + 2px); }
    textarea.form-control { min-height: 80px !important; }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">📝 Add Success Story</h5>
        <a href="{{ route('success_stories.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('success_stories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow-sm">
        @csrf

        <div class="form-floating mb-2">
            <input type="text" name="title" class="form-control form-control-sm" id="title" placeholder="Story Title" required>
            <label for="title">Title <span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="author" class="form-control form-control-sm" id="author" placeholder="Author Name">
            <label for="author">Author</label>
        </div>

        <div class="mb-2">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control form-control-sm" id="cover_image" accept=".jpg,.jpeg,.png">
            <small class="text-muted">Accepted formats: JPG, JPEG, PNG</small>
        </div>

        <div class="mb-2">
            <label for="content-editor" class="form-label">Story Content <span class="text-danger">*</span></label>
            <textarea name="body" id="content-editor" class="form-control"></textarea>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-paper-plane"></i> Publish Story
            </button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor
        .create(document.querySelector('#content-editor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', '|',
                'undo', 'redo'
            ]
        })
        .then(editor => {
            console.log('CKEditor ready');
            // No need to sync — CKEditor updates textarea automatically
        })
        .catch(error => {
            console.error('CKEditor failed:', error);
        });
});
</script>
@endsection