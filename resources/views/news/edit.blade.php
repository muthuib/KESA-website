@extends('layouts.app')

@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .form-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #800000; /* Maroon */
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-section-title i {
            color: #800000; /* Maroon */
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
            font-weight: bold;
        }
        
        .image-preview-container {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px dashed #dee2e6;
            margin-top: 0.75rem;
        }
        
        .image-preview-container img,
        .image-preview-container video {
            max-width: 100%;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .file-input-wrapper {
            position: relative;
        }
        
        .file-input-wrapper .form-control {
            padding: 0.6rem;
        }
        
        .file-input-wrapper .form-control:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        
        .badge-optional {
            background: #6c757d;
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            margin-left: 0.5rem;
        }
        
        .current-media-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }
        
        .btn-update {
            padding: 0.6rem 2.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            background-color: #800000;
			color:white;
            border-color: #800000;
            transition: all 0.3s ease;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(128, 0, 0, 0.3);
            background-color: #660000; /* Darker maroon on hover */
            border-color: #660000;
        }
        
        .btn-update i {
            margin-right: 0.5rem;
        }
        
        .form-control:focus {
            border-color: #800000; /* Maroon */
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
        }
        
        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .additional-images-section {
            background: #fff8f0;
            border: 1px solid #f0e0d0;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 1rem;
        }
        
        .additional-images-section .form-section-title {
            border-bottom-color: #800000; /* Maroon */
        }
        
        .additional-images-section .form-section-title i {
            color: #800000; /* Maroon */
        }
        
        .help-text {
            display: block;
            margin-top: 0.3rem;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .quill-wrapper {
            background: white;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        
        .quill-wrapper:focus-within {
            border-color: #800000; /* Maroon */
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
        }
        
        #editor {
            height: 250px;
            background: white;
            border-radius: 0 0 8px 8px;
        }
        
        .ql-toolbar {
            border-radius: 8px 8px 0 0;
            background: #fafafa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e9ecef;
        }
        
        /* Quill editor customization - maroon theme */
        .ql-snow .ql-picker.ql-header .ql-picker-label:hover,
        .ql-snow .ql-picker.ql-header .ql-picker-item:hover {
            color: #800000 !important;
        }
        
        .ql-snow .ql-picker.ql-header .ql-picker-item.ql-selected,
        .ql-snow .ql-picker.ql-header .ql-picker-label.ql-active {
            color: #800000 !important;
        }
        
        .ql-snow .ql-stroke.ql-active {
            stroke: #800000 !important;
        }
        
        .ql-snow .ql-fill.ql-active {
            fill: #800000 !important;
        }
        
        @media (max-width: 768px) {
            .form-section {
                padding: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
<div class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-edit" style="color: #800000;"></i> Edit News
        </h3>
        <a href="{{ route('news.index') }}" class="btn btn-dark">
            <i class="fas fa-arrow-left"></i> Back
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

        {{-- Basic Information Section --}}
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-info-circle"></i>
                Basic Information
            </div>
            
            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label required-field">News Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $news->title) }}"
                    placeholder="Enter news title..."
                    required
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                {{-- Date --}}
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label required-field">Date</label>
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

                {{-- Photo Credit --}}
                <div class="col-md-6 mb-3">
                    <label for="photo_credit" class="form-label">
                        Photo Credit
                        <span class="badge-optional">Optional</span>
                    </label>
                    <input
                        type="text"
                        id="photo_credit"
                        name="photo_credit"
                        class="form-control @error('photo_credit') is-invalid @enderror"
                        placeholder="e.g., Getty Images"
                        value="{{ old('photo_credit', $news->photo_credit) }}"
                    >
                    @error('photo_credit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i> Credit the photographer or source of the main image
                    </small>
                </div>
            </div>
        </div>

        {{-- Media Section --}}
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-image"></i>
                Main Media
            </div>
            
            <div class="mb-3">
                <label for="media" class="form-label">Upload Main Image or Video</label>
                <div class="file-input-wrapper">
                    <input
                        type="file"
                        id="media"
                        name="media"
                        class="form-control @error('media') is-invalid @enderror"
                        accept="image/*,video/*"
                    >
                </div>
                @error('media')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="help-text">
                    <i class="fas fa-info-circle"></i> Supported formats: JPG, PNG, GIF, WebP, MP4, MOV, AVI (Max: 50MB)
                </small>

                {{-- Current main media preview --}}
                @if($news->image)
                    <div class="image-preview-container">
                        <p class="current-media-label">
                            <i class="fas fa-check-circle text-success"></i> Current main media:
                        </p>
                        @php
                            $ext = strtolower(pathinfo($news->image, PATHINFO_EXTENSION));
                            $videoExts = ['mp4', 'mov', 'avi', 'webm'];
                        @endphp

                        @if(in_array($ext, $videoExts))
                            <video src="{{ asset($news->image) }}" controls style="max-width: 300px;" class="rounded"></video>
                        @else
                            <img src="{{ asset($news->image) }}" alt="Current main image" style="max-width: 300px;" class="rounded">
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Content Section --}}
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-align-left"></i>
                Content
                <span class="badge-optional" style="background: #dc3545;">Required</span>
            </div>
            
            <div class="mb-3">
                <label class="form-label">News Content</label>
                <div class="quill-wrapper">
                    <div id="editor">{!! old('content', $news->content) !!}</div>
                </div>
                <input type="hidden" name="content" id="content">
                <small class="help-text">
                    <i class="fas fa-info-circle"></i> Use the toolbar to format your content. You can add images and links.
                </small>
            </div>
        </div>

        {{-- Additional Images Section --}}
        <div class="additional-images-section">
            <div class="form-section-title">
                <i class="fas fa-images"></i>
                Additional Images
                <span class="badge-optional">Optional</span>
            </div>
            
            <p class="text-muted mb-3">
                <i class="fas fa-info-circle"></i> Add up to 3 additional images to enhance your news article.
            </p>

            {{-- Additional Image 1 --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="media1" class="form-label">Additional Image 1</label>
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
                        <div class="image-preview-container">
                            <p class="current-media-label">
                                <i class="fas fa-check-circle text-success"></i> Current image:
                            </p>
                            <img src="{{ asset($news->media1) }}" alt="Additional image 1" style="max-width: 200px;" class="rounded">
                        </div>
                    @endif
                </div>

                {{-- Additional Image 2 --}}
                <div class="col-md-6 mb-3">
                    <label for="media2" class="form-label">Additional Image 2</label>
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
                        <div class="image-preview-container">
                            <p class="current-media-label">
                                <i class="fas fa-check-circle text-success"></i> Current image:
                            </p>
                            <img src="{{ asset($news->media2) }}" alt="Additional image 2" style="max-width: 200px;" class="rounded">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Additional Image 3 --}}
            <div class="row">
                <div class="col-md-6 mb-0">
                    <label for="media3" class="form-label">Additional Image 3</label>
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
                        <div class="image-preview-container">
                            <p class="current-media-label">
                                <i class="fas fa-check-circle text-success"></i> Current image:
                            </p>
                            <img src="{{ asset($news->media3) }}" alt="Additional image 3" style="max-width: 200px;" class="rounded">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-buttons">
            <button type="submit" class="btn btn-update">
                <i class="fas fa-save"></i> Update News
            </button>
            <a href="{{ route('news.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
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
        placeholder: 'Write your news content here...'
    });

    document.getElementById('newsForm').addEventListener('submit', function (e) {
        const content = quill.root.innerHTML;

        // Guard: prevent empty content submission
        if (!content.trim() || content.trim() === '<p><br></p>') {
            e.preventDefault();
            alert('Content is required! Please add some content to your news article.');
            return;
        }

        document.getElementById('content').value = content;
    });

    // File input enhancement - show filename
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const label = this.closest('.mb-3, .col-md-6').querySelector('.form-label');
                if (label && !label.querySelector('.file-name')) {
                    const span = document.createElement('span');
                    span.className = 'file-name badge bg-info ms-2';
                    span.textContent = fileName;
                    label.appendChild(span);
                } else if (label) {
                    const span = label.querySelector('.file-name');
                    if (span) span.textContent = fileName;
                }
            }
        });
    });
</script>
@endsection