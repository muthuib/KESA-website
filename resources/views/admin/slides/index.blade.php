@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slides</h1>
    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add Slide</a>
    <div class="row">
        @foreach ($slides as $slide)
        <div class="col-md-4">
            <div class="card" style="width: 25rem; height: 19rem; overflow: hidden;">
                
                <!-- Slide Image -->
                <img src="{{ asset($slide->IMAGE_PATH) }}" class="card-img-top" alt="Slide Image" style="object-fit: cover; height: 11rem; width: 100%;">

                <div class="card-body">
                    <!-- Caption with 'Read More' -->
                    <p class="card-text">
                        {{ Str::limit($slide->CAPTION, 60) }}
                        @if (strlen($slide->CAPTION) > 60)
                            <a href="{{ route('admin.slides.show', $slide->ID) }}" class="text-primary">Read More</a>
                        @endif
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.slides.edit', $slide->ID) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.slides.destroy', $slide->ID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slide?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
