@extends('layouts.app')

@section('styles')
<style>
    .card {
        border-radius: 12px;
        border: none;
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 3px solid #800000;
        padding: 1.25rem 1.5rem;
    }
    
    .card-header h4 {
        color: #800000;
        font-weight: 600;
    }
    
    .card-header h4 i {
        color: #800000;
    }
    
    .event-title {
        color: #800000;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #800000;
    }
    
    .event-detail {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 0.75rem;
        border-left: 3px solid #800000;
        transition: all 0.3s ease;
    }
    
    .event-detail:hover {
        background: #f0f0f0;
        transform: translateX(5px);
    }
    
    .event-detail strong {
        color: #2c3e50;
        min-width: 140px;
        display: inline-block;
    }
    
    .event-detail i {
        color: #800000;
        width: 24px;
    }
    
    .event-image-container {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        margin: 1rem 0;
        text-align: center;
    }
    
    .event-image-container strong {
        display: block;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 1.05rem;
    }
    
    .event-image-container strong i {
        color: #800000;
    }
    
    .event-image-container img {
        max-width: 100%;
        max-height: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 1px solid #dee2e6;
        padding: 0.25rem;
        background: white;
    }
    
    .photo-credit {
        background: #fff8f0;
        border-left: 4px solid #800000;
        padding: 0.75rem 1rem;
        margin: 1rem 0;
        border-radius: 4px;
        font-size: 0.95rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .photo-credit i {
        color: #800000;
        font-size: 1.1rem;
    }
    
    .photo-credit span {
        color: #333;
        font-weight: 500;
    }
    
    .event-description {
        background: white;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        margin-top: 0.5rem;
        line-height: 1.8;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .back-button {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #e9ecef;
    }
    
    .back-button .btn {
        padding: 0.6rem 2rem;
        font-weight: 500;
        border-radius: 8px;
    }
    
    .event-link a {
        color: #800000;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .event-link a:hover {
        color: #660000;
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .event-title {
            font-size: 1.5rem;
        }
        
        .event-detail strong {
            min-width: 100px;
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .event-image-container img {
            max-height: 300px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Card Header with Back Button -->
    <div class="card shadow-lg p-4 mb-4 bg-white rounded">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h4 class="mb-0">
                <i class="fas fa-calendar-alt"></i> Event Details
            </h4>
            <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <!-- Event Title -->
            <h2 class="text-center event-title">{{ $event->name }}</h2>
            
            <!-- Event Details -->
            <div class="event-detail">
                <strong><i class="fas fa-map-pin"></i> Venue:</strong> 
                {{ $event->venue }}
            </div>
            
            <div class="event-detail">
                <strong><i class="fas fa-calendar-day"></i> Date:</strong> 
                {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y') }}
            </div>
            
            <div class="event-detail">
                <strong><i class="fas fa-clock"></i> Start Time:</strong> 
                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
            </div>
            
            <div class="event-detail">
                <strong><i class="fas fa-clock"></i> End Time:</strong> 
                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
            </div>
            
            @if($event->link)
                <div class="event-detail event-link">
                    <strong><i class="fas fa-link"></i> Registration Link:</strong> 
                    <a href="{{ $event->link }}" target="_blank">{{ $event->link }}</a>
                </div>
            @endif
            
            <!-- Display Image -->
            @if($event->image)
                <div class="event-image-container">
                    <strong><i class="fas fa-image"></i> Event Image</strong>
                    <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="img-fluid">
                </div>
            @endif
            
            <!-- Photo Credit -->
            @if($event->photo_credit)
                <div class="photo-credit">
                    <i class="fas fa-camera"></i> 
                    <em>Photo Credit: <span>{{ $event->photo_credit }}</span></em>
                </div>
            @endif
            
            <!-- Description -->
            @if($event->description)
                <div class="mt-3">
                    <strong><i class="fas fa-align-left" style="color: #800000;"></i> Description:</strong>
                    <div class="event-description">
                        {{ $event->description }}
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="back-button text-center">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection