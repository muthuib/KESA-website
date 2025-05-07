@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Blog Post</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('blog.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>

    <!-- Display Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
        @csrf @method('PUT')

        <input type="text" name="title" class="form-control mb-3 @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
        <input type="date" name="date" class="form-control mb-3 @error('date') is-invalid @enderror" value="{{ old('date', $blog->date) }}" required>
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <input type="file" name="image" class="form-control mb-3 @error('image') is-invalid @enderror">
        @if($blog->image)
            <img src="{{ asset($blog->image) }}" style="max-width: 200px;" class="mb-2">
        @endif
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div id="editor" style="height: 200px;">{!! old('content', $blog->content) !!}</div>
        <input type="hidden" name="content" id="content">

        <button class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
  // Initialize Quill editor
  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'align': [] }],
        ['link', 'image'],
        ['clean']
      ]
    },
    placeholder: 'Edit your blog content...'
  });

  // Assign the Quill content to the hidden input before form submission
  document.querySelector('#blogForm').onsubmit = function (event) {
    const content = quill.root.innerHTML;
    
    if (!content.trim()) {
      event.preventDefault(); // Prevent form submission if content is empty
      alert('Content is required!');
      return;
    }

    document.querySelector('#content').value = content;
  };
</script>
@endsection

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Ensure links inside the Quill editor are blue */
    .ql-editor a {
        color: #007bff !important; /* Set to blue */
        text-decoration: none !important; /* Optional: Remove underline */
    }

    .ql-editor a:hover {
        text-decoration: underline !important; /* Underline on hover */
        color: #0056b3 !important; /* Darker blue on hover */
    }
</style>
@endsection
