@extends('layouts.app')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor {
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        min-height: 200px;
        padding: 10px;
    }
</style>
@endsection

@section('content')
<div class="container mt-2">
    <h4>Add News</h4>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('news.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>

    <form id="newsForm" action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="title" class="form-control mb-3" placeholder="Title" required>

        <input type="date" name="date" class="form-control mb-3" required>

        <input type="file" name="image" class="form-control mb-3">

        <!-- Quill Editor Visible to User -->
        <label for="editor">Content:</label>
        <div id="editor" class="mb-3"></div>

        <!-- Hidden Input to Store HTML Content -->
        <input type="hidden" name="content" id="content">
        {{-- Additional Images Section --}}
        <p style="color: brown; font-weight: bold;">Add Additional News Images</p>

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

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your news content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }], // ✅ Text color and background color
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // On form submit, store Quill's HTML content inside hidden input
    document.getElementById('newsForm').onsubmit = function () {
        document.getElementById('content').value = quill.root.innerHTML;
    };
</script>
@endsection
