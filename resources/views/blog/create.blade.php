@extends('layouts.app')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor {
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 200px;
        padding: 0.75rem;
        font-size: 0.875rem; /* small font */
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

        <div class="form-floating mb-2">
            <input type="text" name="author" class="form-control form-control-sm" id="author" placeholder="Author Name" required>
            <label for="author">Author</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="category" class="form-control form-control-sm" id="category" placeholder="Category" required>
            <label for="category">Category</label>
        </div>

        <div class="mb-2">
            <label for="editor" class="form-label">Content</label>
            <div id="editor"></div>
        </div>

        <input type="hidden" name="content" id="content">

        <!-- <div class="form-floating mb-2">
            <input type="text" name="copyright" class="form-control form-control-sm" id="copyright" placeholder="Copyright" required>
            <label for="copyright">Copyright</label>
        </div>

        <div class="form-floating mb-2">
            <textarea name="ownership_disclaimer" class="form-control form-control-sm" id="ownership_disclaimer" placeholder="Ownership Disclaimer" required></textarea>
            <label for="ownership_disclaimer">Ownership Disclaimer</label>
        </div> -->

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-paper-plane"></i> Publish Blog
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your blog content here...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ color: [] }, { background: [] }],
                [{ align: [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    document.getElementById('blogForm').onsubmit = function () {
        document.getElementById('content').value = quill.root.innerHTML;
    };
</script>
@endsection
