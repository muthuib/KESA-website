@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card Header with Back Button -->
    <div class="card shadow-lg p-4 mb-4 bg-white rounded">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h4 class="mb-0 text-primary">Event Details</h4>
            <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <!-- Event Title -->
            <h2 class="text-center text-uppercase text-success">{{ $event->name }}</h2>
            <!-- Event Details -->
            <!-- <p><strong>📍 Location:</strong> {{ $event->location }}</p> -->
            <p><strong>🏛 Venue:</strong> {{ $event->venue }}</p>
            <p><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</p>
            
            <!-- Display Start and End Time -->
            <p><strong>⏰ Start Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</p>
            <p><strong>⏳ End Time:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
            <p><strong>Registration Link:</strong> <a href="{{ $event->link }}" target="_blank" class="text-decoration-none">{{ $event->link }}</a></p>
            
            <!-- Display Image -->
            @if($event->image)
                <div class="text-center mb-3">
                    <strong>📸 Event Image:</strong><br>
                    <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="img-fluid rounded shadow-sm" style="max-width: 500px;">
                </div>
            @endif

            <p><strong>📝 Description:</strong> {{ $event->description }}</p>

            <!-- Back Button -->
            <div class="text-center mt-4">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
