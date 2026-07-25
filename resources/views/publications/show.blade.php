@extends('layouts.app')

@section('head')
    <meta property="og:title" content="{{ $publication->title }}" />
    <meta property="og:description" content="{{ strip_tags(Str::limit($publication->description, 160)) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ route('publications.display.show', $publication->slug) }}" />
    <meta property="og:image" content="{{ $publication->cover_image ? asset($publication->cover_image) : asset('assets/pictures/logo.jpg') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $publication->title }}" />
    <meta name="twitter:description" content="{{ strip_tags(Str::limit($publication->description, 160)) }}" />
    <meta name="twitter:image" content="{{ $publication->cover_image ? asset($publication->cover_image) : asset('assets/pictures/logo.jpg') }}" />
@endsection

@section('styles')
<style>
    .publication-title {
        color: #800000;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #800000;
    }
    
    .cover-image-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    
    .cover-image {
        max-width: 350px;
        border: 3px solid #800000;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .cover-image:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .photo-credit {
        background: linear-gradient(135deg, rgba(128, 0, 0, 0.08), rgba(128, 0, 0, 0.02));
        border-left: 4px solid #800000;
        padding: 0.5rem 1rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 350px;
    }
    
    .photo-credit i {
        color: #800000;
        font-size: 1rem;
    }
    
    .photo-credit .credit-label {
        color: #800000;
        font-weight: 500;
    }
    
    .photo-credit .credit-name {
        color: #333;
        font-weight: 600;
        font-style: italic;
    }
    
    .detail-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-item strong {
        color: #800000;
        min-width: 120px;
        display: inline-block;
    }
    
    .detail-item i {
        color: #800000;
        width: 20px;
        margin-right: 5px;
    }
    
    .description-box {
        border-left: 4px solid #800000;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-radius: 4px;
        line-height: 1.8;
        margin-top: 0.5rem;
    }
    
    .btn-download {
        padding: 0.6rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        background-color: #800000;
        border-color: #800000;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(128, 0, 0, 0.3);
        background-color: #660000;
        border-color: #660000;
        color: white;
    }
    
    .btn-download i {
        margin-right: 0.5rem;
    }
    
    .no-cover {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        padding: 1.5rem 2rem;
        border-radius: 8px;
        display: inline-block;
        color: #6c757d;
    }
    
    .no-cover i {
        font-size: 1.5rem;
        margin-right: 0.5rem;
        color: #800000;
    }
    
    @media (max-width: 768px) {
        .cover-image {
            max-width: 100%;
        }
        
        .photo-credit {
            max-width: 100%;
        }
        
        .detail-item strong {
            min-width: 100px;
            display: block;
            margin-bottom: 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="publication-title">{{ $publication->title }}</h3>
        <a href="{{ route('publications.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Cover Image -->
            <div class="cover-image-container">
                @if($publication->cover_image)
                    <img src="{{ asset($publication->cover_image) }}" 
                        alt="Cover Image for {{ $publication->title }}" 
                        class="cover-image">
                @else
                    <div class="no-cover">
                        <i class="bi bi-image"></i>
                        No cover image available.
                    </div>
                @endif
            </div>
            
            <!-- Photo Credit -->
            @if($publication->photo_credit)
                <div class="photo-credit">
                    <i class="fas fa-camera"></i>
                    <span class="credit-label">Photo Credit:</span>
                    <span class="credit-name">{{ $publication->photo_credit }}</span>
                </div>
            @endif

            <!-- Details -->
            <div class="mt-3">
                <div class="detail-item">
                    <strong><i class="fas fa-user"></i> Authors:</strong> 
                    {{ $publication->authors ?? 'Not specified' }}
                </div>
                <div class="detail-item">
                    <strong><i class="fas fa-file-alt"></i> File Size:</strong> 
                    {{ number_format($publication->file_size / 1024, 2) }} KB
                </div>
                <div class="detail-item">
                    <strong><i class="fas fa-download"></i> Downloads:</strong> 
                    {{ $publication->downloads }}
                </div>
                <div class="detail-item">
                    <strong><i class="fas fa-calendar-day"></i> Uploaded On:</strong> 
                    {{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}
                </div>
            </div>

            <!-- Description -->
            <div class="mt-4">
                <h5 style="color: #800000; font-weight: 600;">
                    <i class="fas fa-align-left"></i> Description
                </h5>
                <div class="description-box">
                    {!! nl2br(e($publication->description ?? 'No description provided.')) !!}
                </div>
            </div>

            <!-- Download Button -->
            <div class="mt-4">
                <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-download">
                    <i class="fas fa-download"></i> Download Publication
                </a>
            </div>
        </div>
        
        <!-- Right Column - Additional Info -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-radius: 12px; border-top: 3px solid #800000;">
                <div class="card-body">
                    <h5 class="card-title" style="color: #800000; font-weight: 600;">
                        <i class="fas fa-info-circle"></i> Publication Info
                    </h5>
                    <hr style="border-color: #800000;">
                    <p class="mb-2">
                        <strong style="color: #800000;">Title:</strong><br>
                        {{ Str::limit($publication->title, 50) }}
                    </p>
                    <p class="mb-2">
                        <strong style="color: #800000;">Authors:</strong><br>
                        {{ $publication->authors ?? 'Not specified' }}
                    </p>
                    <p class="mb-0">
                        <strong style="color: #800000;">Downloads:</strong><br>
                        {{ $publication->downloads }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection