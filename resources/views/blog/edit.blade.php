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
        font-size: 0.875rem;
    }

    .ql-editor a {
        color: #007bff !important;
        text-decoration: none !important;
    }

    .ql-editor a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
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
        <h5 class="fw-bold mb-0">✏️ Edit Blog Post</h5>
        <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger p-2">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogForm" class="bg-white p-3 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="form-floating mb-2">
            <input type="text" name="title" class="form-control form-control-sm @error('title') is-invalid @enderror" id="title" value="{{ old('title', $blog->title) }}" placeholder="Title" required>
            <label for="title">Blog Title</label>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-2">
            <input type="date" name="date" class="form-control form-control-sm @error('date') is-invalid @enderror" id="date" value="{{ old('date', $blog->date) }}" required>
            <label for="date">Publish Date</label>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
            <label for="image" class="form-label">Featured Image</label>
            <input type="file" name="image" class="form-control form-control-sm @error('image') is-invalid @enderror" id="image">
            @if($blog->image)
                <img src="{{ asset($blog->image) }}" alt="Current Image" class="mt-2" style="max-width: 150px; border-radius: 5px;">
            @endif
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="author" class="form-control form-control-sm @error('author') is-invalid @enderror" id="author" value="{{ old('author', $blog->author) }}" placeholder="Author Name" required>
            <label for="author">Author</label>
            @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="category" class="form-control form-control-sm @error('category') is-invalid @enderror" id="category" value="{{ old('category', $blog->category) }}" placeholder="Category" required>
            <label for="category">Category</label>
            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- <div class="form-floating mb-2">
            <input type="text" name="copyright" class="form-control form-control-sm @error('copyright') is-invalid @enderror" id="copyright" value="{{ old('copyright', $blog->copyright) }}" placeholder="Copyright Info" required>
            <label for="copyright">Copyright Info</label>
            @error('copyright') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-2">
            <textarea name="ownership_disclaimer" class="form-control form-control-sm @error('ownership_disclaimer') is-invalid @enderror" id="ownership_disclaimer" placeholder="Ownership Disclaimer" style="height: 100px;" required>{{ old('ownership_disclaimer', $blog->ownership_disclaimer) }}</textarea>
            <label for="ownership_disclaimer">Ownership Disclaimer</label>
            @error('ownership_disclaimer') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div> -->

        <div class="mb-2">
            <label for="editor" class="form-label">Content</label>
            <div id="editor">{!! old('content', $blog->content) !!}</div>
        </div>
        <input type="hidden" name="content" id="content">

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-save"></i> Update Blog
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
        placeholder: 'Edit your blog content...',
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

    document.getElementById('blogForm').onsubmit = function (event) {
        const content = quill.root.innerHTML;
        if (!content.trim()) {
            event.preventDefault();
            alert('Content is required!');
            return;
        }
        document.getElementById('content').value = content;
    };
</script>
@endsection
