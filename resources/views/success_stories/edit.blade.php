@extends('layouts.app')

@section('title', 'Edit Success Story')

@section('styles')
<style>
    .ck-editor__editable {
        min-height: 300px;
    }
    .img-thumbnail {
        max-width: 220px;
        height: auto;
    }
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

    <form action="{{ route('success_stories.update', $success_story->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="editStoryForm">

        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">
                Title <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control @error('title') is-invalid @enderror" 
                   value="{{ old('title', $success_story->title) }}" 
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Author -->
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" 
                   name="author" 
                   id="author" 
                   class="form-control" 
                   value="{{ old('author', $success_story->author) }}" 
                   placeholder="e.g. Jane Doe">
        </div>

        <!-- Cover Image -->
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            @if($success_story->cover_image)
                <div class="mb-2">
                    <img src="{{ asset($success_story->cover_image) }}" 
                         alt="Current Cover" 
                         class="img-thumbnail rounded shadow-sm">
                    <small class="text-muted d-block mt-1">Current image</small>
                </div>
            @endif
            <input type="file" 
                   name="cover_image" 
                   id="cover_image" 
                   class="form-control form-control-sm" 
                   accept=".jpg,.jpeg,.png">
            <small class="text-muted">JPG, JPEG, or PNG only</small>
        </div>

        <!-- Story Body with CKEditor -->
        <div class="mb-3">
            <label for="body-editor" class="form-label">
                Story Body <span class="text-danger">*</span>
            </label>

            {{-- Hidden textarea – NO `required` to avoid browser focus error --}}
            <textarea name="body" 
                      id="body-editor" 
                      class="form-control d-none">
                {{ old('body', $success_story->body) }}
            </textarea>

            @error('body')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">
                Update Story
            </button>
            <a href="{{ route('success_stories.index') }}" class="btn btn-secondary px-4">
                Cancel
            </a>
        </div>
    </form>
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
            window.ckEditor = ed; // for debugging
            console.log('CKEditor loaded successfully');

            // Optional: Hide the original textarea visually
            textarea.style.display = 'none';
        })
        .catch(err => {
            console.error('CKEditor failed to load:', err);
            alert('Rich text editor failed to load. Please try again.');
        });

    // === CLIENT-SIDE VALIDATION (Recommended) ===
    const form = document.getElementById('editStoryForm');
    form.addEventListener('submit', function (e) {
        if (editor) {
            const content = editor.getData().trim();
            if (!content) {
                e.preventDefault();
                alert('Please write the success story content.');
                return;
            }
            // Sync final content
            textarea.value = content;
        }
    });
});
</script>
@endsection