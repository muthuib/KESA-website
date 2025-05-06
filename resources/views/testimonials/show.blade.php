@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>{{ $testimonial->name }}</h2>
    <p><strong>Position:</strong> {{ $testimonial->position }}</p>
    <p><strong>Date:</strong> {{ $testimonial->date ? $testimonial->date->format('Y-m-d') : 'N/A' }}</p>
    <p><strong>Content:</strong></p>
    <p>{{ $testimonial->content }}</p>

    @if($testimonial->photo)
        <p><strong>Photo:</strong></p>
        <img src="{{ asset('testimonials/' . $testimonial->photo) }}" class="img-fluid" width="300">
    @else
        <p>No photo available.</p>
    @endif

    <a href="{{ route('testimonials.index') }}" class="btn btn-primary mt-3">Back to List</a>
</div>
@endsection
