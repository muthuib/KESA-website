@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Live Event</h2>
        <a href="{{ route('live-events.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('live-events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $event->title }}" required>
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Platform</label>
            <select id="platform" name="platform" class="form-select" required>
                <option value="YouTube" {{ $event->platform == 'YouTube' ? 'selected' : '' }}>YouTube</option>
                <option value="Facebook" {{ $event->platform == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                <option value="Zoom" {{ $event->platform == 'Zoom' ? 'selected' : '' }}>Zoom</option>
                <option value="Google Meet" {{ $event->platform == 'Google Meet' ? 'selected' : '' }}>Google Meet</option>
                <option value="Other" {{ $event->platform == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Event Link</label>
            <input type="url" id="link" name="link" class="form-control" value="{{ $event->link }}" required>
        </div>

        <div class="mb-3">
            <label for="date_time" class="form-label">Event Date & Time</label>
            <input type="datetime-local" id="date_time" name="date_time" class="form-control"
                   value="{{ date('Y-m-d\TH:i', strtotime($event->date_time)) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Event</button>
    </form>
</div>
@endsection
