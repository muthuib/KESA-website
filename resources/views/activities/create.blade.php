@extends('layouts.app')

@section('styles')
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
        border-bottom: 2px solid #800000;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-section-title i {
        color: #800000;
    }
    
    .required-field::after {
        content: " *";
        color: #dc3545;
        font-weight: bold;
    }
    
    .badge-optional {
        background: #6c757d;
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        margin-left: 0.5rem;
    }
    
    .help-text {
        display: block;
        margin-top: 0.3rem;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .form-control:focus {
        border-color: #800000;
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
    }
    
    .form-label {
        font-weight: 500;
        color: #2c3e50;
    }
    
    .btn-submit {
        padding: 0.6rem 2.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 8px;
        background-color: #800000;
        border-color: #800000;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(128, 0, 0, 0.3);
        background-color: #660000;
        border-color: #660000;
        color: white;
    }
    
    .btn-submit i {
        margin-right: 0.5rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #e9ecef;
    }
    
    .card {
        border-radius: 12px;
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 3px solid #800000;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }
    
    .card-header h4 {
        color: #800000;
        font-weight: 600;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .quill-wrapper {
        background: white;
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    
    .quill-wrapper:focus-within {
        border-color: #800000;
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
    }
    
    #quill-editor {
        height: 250px;
        background: white;
        border-radius: 0 0 8px 8px;
    }
    
    .ql-toolbar {
        border-radius: 8px 8px 0 0;
        background: #fafafa;
        border-bottom: 1px solid #dee2e6;
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
<div class="container-fluid py-4" style="padding-left: 30px; padding-right: 30px;">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle" style="color: #800000;"></i> Add Past Event
                    </h4>
                    <a href="{{ route('activities.index') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-backward"></i> Back
                    </a>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                              @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="activity-form" action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Event Information Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Event Information
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label required-field">Event Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label">Venue</label>
                                    <input type="text" id="location" name="location" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Date & Time Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-calendar-alt"></i>
                                Date & Time
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" id="date" name="date" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" id="start_time" name="start_time" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" id="end_time" name="end_time" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Media Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-image"></i>
                                Event Media
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="media" class="form-label required-field">Upload Video/Image</label>
                                    <input type="file" id="media" name="media" class="form-control" accept="video/*,image/*" required>
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Supported formats: JPG, PNG, GIF, WebP, MP4, MOV, AVI
                                    </small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="photo_credit" class="form-label">
                                        Photo Credit
                                        <span class="badge-optional">Optional</span>
                                    </label>
                                    <input type="text" id="photo_credit" name="photo_credit" class="form-control" placeholder="e.g., Getty Images" value="{{ old('photo_credit') }}">
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Credit the photographer or source of the main image
                                    </small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="youtube_link" class="form-label">YouTube Link (Optional)</label>
                                    <input type="url" id="youtube_link" name="youtube_link" class="form-control" placeholder="https://www.youtube.com/watch?v=example">
                                </div>
                            </div>
                        </div>

                        {{-- Content Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-align-left"></i>
                                Description
                            </div>
                            
                            <div class="mb-3">
                                <label for="quill-editor" class="form-label">Event Description</label>
                                <div class="quill-wrapper">
                                    <div id="quill-editor"></div>
                                </div>
                                <input type="hidden" name="description" id="description">
                            </div>
                        </div>

                        {{-- Additional Images Section --}}
                        <div class="form-section" style="background: #fff8f0; border-color: #f0e0d0;">
                            <div class="form-section-title">
                                <i class="fas fa-images"></i>
                                Additional Images
                                <span class="badge-optional">Optional</span>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-info-circle"></i> Add up to 3 additional images to enhance your event.
                            </p>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="media1" class="form-label">Additional Image 1</label>
                                    <input type="file" id="media1" name="media1" class="form-control" accept="image/*">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="media2" class="form-label">Additional Image 2</label>
                                    <input type="file" id="media2" name="media2" class="form-control" accept="image/*">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="media3" class="form-label">Additional Image 3</label>
                                    <input type="file" id="media3" name="media3" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save"></i> Add Event
                            </button>
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Quill JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write event description...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Ensure hidden input gets Quill content before form submission
        document.getElementById('activity-form').addEventListener('submit', function (e) {
            const content = quill.root.innerHTML;
            
            // Guard: prevent empty content submission
            if (!content.trim() || content.trim() === '<p><br></p>') {
                e.preventDefault();
                alert('Description is required! Please add some content.');
                return;
            }
            
            document.getElementById('description').value = content;

            // Add validation to restrict image uploads to a maximum of 4
            const imageInputs = [
                document.getElementById('media'), 
                document.getElementById('media1'), 
                document.getElementById('media2'), 
                document.getElementById('media3')
            ];
            const totalFiles = imageInputs.reduce((total, input) => {
                if (input && input.files) {
                    return total + input.files.length;
                }
                return total;
            }, 0);

            if (totalFiles > 4) {
                e.preventDefault();
                alert('You can upload a maximum of 4 images total (1 main + 3 additional).');
            }
        });
    });

    // File input enhancement - show filename
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const label = this.closest('.mb-3, .col-md-4, .col-md-6').querySelector('.form-label');
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