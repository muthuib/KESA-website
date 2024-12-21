@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Edit About Us</h1>

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
