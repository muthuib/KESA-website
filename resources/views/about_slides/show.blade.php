@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px; position: relative;">
    <!-- Back Button at top right -->
    <a href="{{ route('about-slides.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back 
    </a>
    
    <h2 class="text-left mb-4">Slide Details</h2>
    <div class="card shadow-sm" style="width: 550px;">
        @if($aboutSlide->IMAGE_PATH)
            <img src="{{ asset($aboutSlide->IMAGE_PATH) }}" class="card-img-top" alt="{{ $aboutSlide->CAPTION }}" style="height: 300px;">
        @endif
        <div class="card-body">
            <h4 class="card-title">{{ $aboutSlide->CAPTION }}</h4>
        </div>
    </div>
</div>
@endsection
