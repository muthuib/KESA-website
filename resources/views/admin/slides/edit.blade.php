@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>Edit Slide</h1>
        </div>
        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.slides.update', ['slide' => $slide->ID]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Slide Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    @if($slide->IMAGE_PATH)
                        <div class="mt-3">
                            <p>Current Image:</p>
                            <img src="{{ asset($slide->IMAGE_PATH) }}" width="200" alt="Current Slide Image">
                        </div>
                    @endif
                </div>
             <!-- Caption field -->
                <div class="mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <input type="text" name="caption" id="caption" class="form-control" value="{{ old('caption', $slide->CAPTION) }}">
                    @error('caption')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Slide</button>
                <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
@endsection
