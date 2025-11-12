@extends('layouts.app')

@section('title', 'Add Success Story')

@section('styles')
<style>
    body { background-color: #f8f9fc; }
    .ck-editor__editable { min-height: 300px; }
    .form-label, .form-floating label { font-size: 0.875rem; }
    .form-control, .form-select { font-size: 0.875rem; padding: 0.375rem 0.75rem; height: calc(1.5em + 0.75rem + 2px); }
    textarea.form-control { min-height: 80px !important; }
    .card { border-radius: 12px; }
    .form-section { margin-bottom: 1.5rem; }
    label strong { font-weight: 600; }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">📝 Add Success Story</h5>
        <a href="{{ route('success_stories.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm p-4 bg-white">
        <form action="{{ route('success_stories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Top Section: Title, Author, Cover, Published Date -->
            <div class="form-section row g-3">
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" name="title" class="form-control form-control-sm" id="title" placeholder="Story Title" required>
                        <label for="title"><strong>Title <span class="text-danger">*</span></strong></label>
                    </div>
                  <div class="mb-2">
                        <label for="published_at" class="form-label"><strong>Published Date <span class="text-danger">*</span></strong></label>
                        <input 
                            type="date" 
                            name="published_at" 
                            class="form-control form-control-sm" 
                            id="published_at"
                            value="{{ now()->format('Y-m-d') }}"
                            required>
                        <small class="text-muted">Select date for story publication</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" name="author" class="form-control form-control-sm" id="author" placeholder="Author Name" required>
                        <label for="author"><strong>Author <span class="text-danger">*</span></strong></label>
                    </div>
                 <div class="mb-2">
                    <label for="cover_image" class="form-label"><strong>Cover Image</strong></label>
                    <input type="file" name="cover_image" class="form-control form-control-sm" id="cover_image" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Accepted formats: JPG, JPEG, PNG</small>
                </div>
                </div>
            </div>

            <!-- Story Content: Full Width at Bottom -->
            <div class="form-section mt-4">
                <label for="content-editor" class="form-label"><strong>Story Content <span class="text-danger">*</span></strong></label>
                <textarea name="body" id="content-editor" class="form-control"></textarea>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-paper-plane"></i> Publish Story
                </button>
            </div>
        </form>
    </div>
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
        .then(editor => console.log('CKEditor ready'))
        .catch(error => console.error('CKEditor failed:', error));
});
</script>
@endsection
