@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Live Event</h2>
        <a href="{{ route('live-events.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
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

    <form action="{{ route('live-events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Platform</label>
            <select id="platform" name="platform" class="form-select" required>
                <option value="YouTube">YouTube</option>
                <option value="Facebook">Facebook</option>
                <option value="Zoom">Zoom</option>
                <option value="Google Meet">Google Meet</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Event Link</label>
            <input type="url" id="link" name="link" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_time" class="form-label">Event Date & Time</label>
            <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Event</button>
    </form>
</div>
@endsection
