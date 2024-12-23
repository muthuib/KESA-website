@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Back button with a backward icon -->
    <div class="mb-3 text-end">
        <a href="{{ route('about.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    <h1 class="text-center" style="font-size: 30px;">Edit About Us</h1>

    <form method="POST" action="{{ route('about.update') }}" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="TITLE">Title</label>
            <input type="text" id="TITLE" name="TITLE" class="form-control" value="{{ $aboutUs->TITLE ?? '' }}" required>
        </div>
        <div class="form-group mt-3">
            <label for="CONTENT">Content</label>
            <textarea id="CONTENT" name="CONTENT" class="form-control" rows="5" required>{{ $aboutUs->CONTENT ?? '' }}</textarea>
        </div>
        <div class="form-group text-center mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
