@extends('layouts.app')

@section('content')
<div class="container mt-5"> <!-- Add margin-top here for spacing -->
    <div class="card">
        <div class="card-header">
            <h1>Add Slide</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="image" class="form-label">Slide Image</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <input type="text" name="caption" id="caption" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Add Slide</button>
            </form>
        </div>
    </div>
</div>
@endsection
