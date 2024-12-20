@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slides</h1>
    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i>Add Slide</a>
    <div class="row">
        @foreach ($slides as $slide)
        <div class="col-md-4">
            <div class="card" style="width: 25rem; height: 19rem; overflow: hidden;">
            <form action="{{ route('admin.slides.destroy', $slide->ID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                <!-- Image with fixed dimensions -->
                <img src="{{ asset($slide->IMAGE_PATH) }}" class="card-img-top" alt="Slide Image" style="object-fit: cover; height: 13rem; width: 100%;">

                <div class="card-body">
                    <!-- Truncate caption and add 'Read More' link -->
                    <p class="card-text">
                        {{ Str::limit($slide->CAPTION, 60) }}
                        @if (strlen($slide->CAPTION) > 60)
                            <a href="{{ route('admin.slides.show', $slide->ID) }}" class="text-primary">Read More</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
