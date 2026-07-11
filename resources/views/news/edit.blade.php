@extends('layouts.app')

@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit News</h2>
        <a href="{{ route('news.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>


    <form
        action="{{ route('news.update', $news->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="newsForm"
    >
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">News Title *</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $news->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label for="date" class="form-label fw-semibold">Date *</label>
            <input
                type="date"
                id="date"
                name="date"
                class="form-control @error('date') is-invalid @enderror"
                value="{{ old('date', $news->date) }}"
                required
            >
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Main Media --}}
        <div class="mb-3">
            <label for="media" class="form-label fw-semibold">Main Image / Video</label>
            <input
                type="file"
                id="media"
                name="media"
                class="form-control @error('media') is-invalid @enderror"
                accept="image/*,video/*"
            >
            @error('media')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Current main media preview --}}
            @if($news->image)
                <div class="mt-2">
                    <p class="text-muted small mb-1">Current main media:</p>
                    @php
                        $ext = strtolower(pathinfo($news->image, PATHINFO_EXTENSION));
                        $videoExts = ['mp4', 'mov', 'avi', 'webm'];
                    @endphp

                    @if(in_array($ext, $videoExts))
                        <video src="{{ asset($news->image) }}" controls style="max-width: 250px;" class="rounded border"></video>
                    @else
                        <img src="{{ asset($news->image) }}" alt="Current main image" style="max-width: 200px;" class="rounded border">
                    @endif
                </div>
            @endif
        </div>

        {{-- Content (Quill) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Content *</label>
            <div id="editor" style="height: 250px;">{!! old('content', $news->content) !!}</div>
            <input type="hidden" name="content" id="content">
        </div>

        {{-- Additional Images --}}
        <p class="mt-4" style="color: brown; font-weight: bold;">Additional News Images</p>

        {{-- Additional Image 1 --}}
        <div class="mb-3">
            <label for="media1" class="form-label">Upload Additional Image 1 (Optional)</label>
            <input
                type="file"
                id="media1"
                name="media1"
                class="form-control @error('media1') is-invalid @enderror"
                accept="image/*"
            >
            @error('media1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($news->media1)
                <div class="mt-2">
                    <p class="text-muted small mb-1">Current additional image 1:</p>
                    <img src="{{ asset($news->media1) }}" alt="Additional image 1" style="max-width: 200px;" class="rounded border">
                </div>
            @endif
        </div>

        {{-- Additional Image 2 --}}
        <div class="mb-3">
            <label for="media2" class="form-label">Upload Additional Image 2 (Optional)</label>
            <input
                type="file"
                id="media2"
                name="media2"
                class="form-control @error('media2') is-invalid @enderror"
                accept="image/*"
            >
            @error('media2')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($news->media2)
                <div class="mt-2">
                    <p class="text-muted small mb-1">Current additional image 2:</p>
                    <img src="{{ asset($news->media2) }}" alt="Additional image 2" style="max-width: 200px;" class="rounded border">
                </div>
            @endif
        </div>

        {{-- Additional Image 3 --}}
        <div class="mb-3">
            <label for="media3" class="form-label">Upload Additional Image 3 (Optional)</label>
            <input
                type="file"
                id="media3"
                name="media3"
                class="form-control @error('media3') is-invalid @enderror"
                accept="image/*"
            >
            @error('media3')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($news->media3)
                <div class="mt-2">
                    <p class="text-muted small mb-1">Current additional image 3:</p>
                    <img src="{{ asset($news->media3) }}" alt="Additional image 3" style="max-width: 200px;" class="rounded border">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-2">
            <i class="fas fa-save"></i> Update News
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Edit your news content...'
    });

    document.getElementById('newsForm').addEventListener('submit', function (e) {
        const content = quill.root.innerHTML;

        // Guard: prevent empty content submission
        if (!content.trim() || content.trim() === '<p><br></p>') {
            e.preventDefault();
            alert('Content is required!');
            return;
        }

        document.getElementById('content').value = content;
    });
</script>
@endsection
