@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slide Details</h1>
     <!-- Back button with a backward icon -->
     <div class="mb-3 text-end">
        <a href="{{route('admin.slides.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    <div class="card" style="width: 100%;">
        <img src="{{ asset($slide->IMAGE_PATH) }}" class="card-img-top" alt="Slide Image" style="object-fit: cover; width: 250px; height: auto;">
        <div class="card-body">
            <h5 class="card-title">{{ $slide->TITLE ?? 'Slide Title' }}</h5>
            <p class="card-text">{{ $slide->CAPTION }}</p>
        </div>
    </div>
</div>
@endsection
