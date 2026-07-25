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
<div class="container" style="margin-top: 20px;">
    <div class="row justify-content-left">
        <div class="col-md-12">
            <!-- Card Container -->
            <div class="card shadow-lg" style="width: 100%;">
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card Header with Back Button -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit" style="color: #800000;"></i> Edit Event
                    </h4>
                    <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">
                        <i class="fa fa-backward"></i> Back
                    </a>
                </div>
                
                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Event Information Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Event Information
                            </div>
                            
                            <div class="row">
                                <!-- Event Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label required-field">Event Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $event->name) }}" placeholder="Enter event name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Venue -->
                                <div class="col-md-6 mb-3">
                                    <label for="venue" class="form-label required-field">Venue</label>
                                    <input type="text" name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror" value="{{ old('venue', $event->venue) }}" placeholder="Enter venue" required>
                                    @error('venue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <!-- Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label required-field">Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $event->start_date) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Start Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label required-field">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- End Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label required-field">End Time</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <!-- Event Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Event Image</label>
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Supported formats: JPG, PNG, GIF, WebP (Max: 10MB)
                                    </small>
                                    
                                    @if($event->image)
                                        <div class="current-image-container">
                                            <strong><i class="fas fa-check-circle text-success"></i> Current Image:</strong><br>
                                            <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="img-fluid mt-2">
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Photo Credit -->
                                <div class="col-md-6 mb-3">
                                    <label for="photo_credit" class="form-label">
                                        Photo Credit
                                        <span class="badge-optional">Optional</span>
                                    </label>
                                    <input type="text" name="photo_credit" id="photo_credit" class="form-control @error('photo_credit') is-invalid @enderror" placeholder="e.g., Getty Images" value="{{ old('photo_credit', $event->photo_credit) }}">
                                    @error('photo_credit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Credit the photographer or source of the event image
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Additional Information Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-link"></i>
                                Additional Information
                            </div>
                            
                            <div class="row">
                                <!-- Event Link -->
                                <div class="col-md-12 mb-3">
                                    <label for="link" class="form-label">Event Registration Link</label>
                                    <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $event->link) }}" placeholder="Enter event registration link">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="help-text">
                                        <i class="fas fa-info-circle"></i> Add a link where users can register for the event
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label required-field">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter event description" required>{{ old('description', $event->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save"></i> Update Event
                            </button>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
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