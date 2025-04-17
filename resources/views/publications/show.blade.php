@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>{{ $publication->title }}</h1>

    <!-- Back Button -->
    <a href="{{ route('publications.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <div class="mt-4">
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
