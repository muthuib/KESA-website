@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slides</h1>
    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary mb-3">Add Slide </a>
    <div class="row">
        @foreach ($slides as $slide)
        <div class="col-md-4">
            <div class="card" style="width: 18rem; height: 19rem; overflow: hidden;">
                <!-- Image with fixed dimensions -->
                <img src="{{ asset($slide->IMAGE_PATH) }}" class="card-img-top" alt="Slide Image" style="object-fit: cover; height: 13rem; width: 100%;">

                <div class="card-body">
                    <p class="card-text">{{ $slide->CAPTION }}</p>
                    <form action="{{ route('admin.slides.destroy', $slide->ID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
