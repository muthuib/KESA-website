@extends('layouts.app')

@section('styles')
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }
        .form-label, .form-floating label {
            font-size: 0.875rem;
        }
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            height: calc(1.5em + 0.75rem + 2px);
        }
        textarea.form-control {
            min-height: 80px !important;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">📝 Create New Blog</h5>
        <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form id="blogForm" action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow-sm">
        @csrf

        <div class="form-floating mb-2">
            <input type="text" name="title" class="form-control form-control-sm" id="title" placeholder="Blog Title" required>
            <label for="title">Blog Title</label>
        </div>

        <div class="form-floating mb-2">
            <input type="date" name="date" class="form-control form-control-sm" id="date" required>
            <label for="date">Publish Date</label>
        </div>

        <div class="mb-2">
            <label for="image" class="form-label">Featured Image</label>
            <input type="file" name="image" class="form-control form-control-sm" id="image">
        </div>

        <!-- 🆕 Image Caption Field -->
        <div class="form-floating mb-2">
            <input type="text" name="name" class="form-control form-control-sm" id="name" placeholder="name">
            <label for="name">Image Caption</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="author" class="form-control form-control-sm" id="author" placeholder="Author Name" required>
            <label for="author">Author</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="category" class="form-control form-control-sm" id="category" placeholder="Category" required>
            <label for="category">Category</label>
        </div>

        <div class="mb-2">
            <label for="content-editor" class="form-label">Content</label>
            <textarea name="content" id="content-editor" class="form-control"></textarea>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-paper-plane"></i> Publish Blog
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
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
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
    </script>
@endsection
