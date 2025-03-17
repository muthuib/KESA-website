@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card Header with Back Button -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0" style="color: brown;">Edit Event</h4>
        <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    
    <h1>{{ $event->name }}</h1>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p><strong>Venue:</strong> {{ $event->venue }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</p>
    
    <!-- Display Start and End Time -->
    <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</p>
    <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
    
    <!-- Display Image -->
    @if($event->image)
        <div class="mb-3">
            <strong>Event Image:</strong><br>
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="img-fluid rounded" style="max-width: 500px; width: 100px;">
        </div>
    @endif

    <p><strong>Description:</strong> {{ $event->description }}</p>

    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
</div>
@endsection
