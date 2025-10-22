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

@section('content')
<div class="container mt-5">
    <h1>{{ $publication->title }}</h1>

    <!-- Back Button -->
    <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <div class="mt-4">
        <!-- Cover Image -->
        <div class="text-left mb-4">
            @if($publication->cover_image)
                <img src="{{ asset($publication->cover_image) }}" 
                    alt="Cover Image for {{ $publication->title }}" 
                    class="img-fluid shadow-sm rounded"
                    style="max-width: 350px; border: 3px solid #a52a2a;">
            @else
                <div class="alert alert-secondary d-inline-block" role="alert">
                    <i class="bi bi-image text-muted me-2"></i>
                    No cover image available.
                </div>
            @endif
        </div>
        <p><strong>Authors:</strong> {{ $publication->authors ?? 'Not specified' }}</p>
        <p><strong>File Size:</strong> {{ number_format($publication->file_size / 1024, 2) }} KB</p>
        <p><strong>Downloads:</strong> {{ $publication->downloads }}</p>
        <p><strong>Uploaded On:</strong> {{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}</p>
        <p><strong>Description:</strong></p>
        <div class="mb-3 border rounded p-3 bg-light">
            {!! nl2br(e($publication->description ?? 'No description provided.')) !!}
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-success">
            <i class="fas fa-download"></i> Download Publication
        </a>
    </div>
</div>
@endsection
