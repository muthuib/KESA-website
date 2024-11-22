@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Add Resource</h1>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="TITLE" class="form-label">Title</label>
                    <input type="text" name="TITLE" class="form-control" id="TITLE" required>
                </div>
                <div class="mb-3">
                    <label for="DESCRIPTION" class="form-label">Description</label>
                    <textarea name="DESCRIPTION" class="form-control" id="DESCRIPTION"></textarea>
                </div>
                <div class="mb-3">
                    <label for="FILE" class="form-label">File</label>
                    <input type="file" name="FILE" class="form-control" id="FILE" required>
                </div>
                <div class="mb-3">
                    <label for="PRICE" class="form-label">Price</label>
                    <input type="number" name="PRICE" class="form-control" id="PRICE" min="0" step="0.01">
                </div>
                <button type="submit" class="btn btn-primary">Add Resource</button>
            </form>
        </div>
    </div>
</div>
@endsection