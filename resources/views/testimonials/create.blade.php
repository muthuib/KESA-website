@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Testimonial</h2>
        <a href="{{ route('testimonials.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Position</label>
            <input name="position" class="form-control">
        </div>
        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content') }}</textarea>
        </div>
        <button class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
