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
    
    .current-image-container {
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        margin-top: 0.5rem;
    }
    
    .current-image-container strong {
        color: #495057;
        font-size: 0.9rem;
    }
    
    .current-image-container img {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        padding: 0.25rem;
        background: white;
        max-width: 200px;
        width: 100%;
        height: auto;
    }
    
    .delete-cover-btn {
        border-radius: 20px;
        font-weight: 500;
        padding: 0.4rem 1.2rem;
        transition: all 0.3s ease;
    }
    
    .delete-cover-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
    
    .current-file-link {
        color: #800000;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .current-file-link:hover {
        color: #660000;
        text-decoration: underline;
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
                        <i class="fas fa-edit" style="color: #800000;"></i> Edit Publication
                    </h4>
                    <a href="{{ route('publications.index') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-backward"></i> Back
                    </a>
                </div>
                
                <div class="card-body">
                    {{-- Separate Delete Cover Form --}}
                    @if($publication->cover_image)
                        <div class="d-flex justify-content-end mb-3">
                            <form action="{{ route('publications.deleteCover', $publication->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this cover image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm delete-cover-btn shadow-sm px-3 py-1">
                                    <i class="fas fa-trash me-1"></i> Remove Cover Image
                                </button>
                            </form>
                        </div>
                    @endif

                    <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Media Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-image"></i>
                                Publication Media
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cover" class="form-label">
                                        Cover Image
                                        <span class="badge-optional">Optional</span>
                                    </label>
                                    <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Upload a JPG, PNG, or WEBP image (max 5MB)
                                    </small>
                                    
                                    @if($publication->cover_image)
                                        <div class="current-image-container">
                                            <strong><i class="fas fa-check-circle text-success"></i> Current Cover:</strong><br>
                                            <img src="{{ asset($publication->cover_image) }}" alt="Cover" class="img-fluid mt-2">
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="photo_credit" class="form-label">
                                        Photo Credit
                                        <span class="badge-optional">Optional</span>
                                    </label>
                                    <input type="text" name="photo_credit" id="photo_credit" class="form-control" placeholder="e.g., Getty Images" value="{{ old('photo_credit', $publication->photo_credit) }}">
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Credit the photographer or source of the cover image
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Publication Information Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Publication Information
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title" class="form-label required-field">Publication Title</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $publication->title) }}" required>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="authors" class="form-label">Author(s)</label>
                                    <input type="text" name="authors" id="authors" class="form-control" value="{{ old('authors', $publication->authors) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $publication->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        {{-- File Upload Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-file-alt"></i>
                                Publication File
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="file" class="form-label">Select a New File</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    <small class="help-text" style="color: #28a745; font-weight: 500;">
                                        <i class="fas fa-info-circle"></i> Leave blank to keep the current file.
                                    </small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mb-0">
                                        <strong><i class="fas fa-file-pdf" style="color: #800000;"></i> Current File:</strong> 
                                        <a href="{{ route('publications.download', $publication->id) }}" target="_blank" class="current-file-link">
                                            <i class="fas fa-download"></i> Download Current Publication
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save"></i> Update Publication
                            </button>
                            <a href="{{ route('publications.index') }}" class="btn btn-secondary">
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
<script>
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