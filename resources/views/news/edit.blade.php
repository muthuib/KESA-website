@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit News</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('news.index') }}" class="btn btn-dark">
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

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm">
        @csrf @method('PUT')

        <input type="text" name="title" class="form-control mb-3 @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
        <input type="date" name="date" class="form-control mb-3 @error('date') is-invalid @enderror" value="{{ old('date', $news->date) }}" required>
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <input type="file" name="image" class="form-control mb-3 @error('image') is-invalid @enderror">
        @if($news->image)
            <img src="{{ asset($news->image) }}" style="max-width: 200px;" class="mb-2">
        @endif
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div id="editor" style="height: 200px;">{!! old('content', $news->content) !!}</div>
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
    placeholder: 'Edit your news content...'
  });

  // Assign the Quill content to the hidden input before form submission
  document.querySelector('#newsForm').onsubmit = function (event) {
    const content = quill.root.innerHTML;
    
    if (!content.trim()) {
      event.preventDefault(); // Prevent form submission if content is empty
      alert('Content is required!');
      return;
    }

    // Set the content to the hidden input field
    document.querySelector('#content').value = content;
  };
</script>
@endsection

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
