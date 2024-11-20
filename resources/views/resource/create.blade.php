@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Centered Heading -->
    <h1 style="text-align: center; margin-bottom: 20px;">Add Resource</h1>

    <!-- Card container with inline CSS -->
    <div class="card" style="border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; max-width: 900px;  margin-left: 50px;">
        <div class="card-body">
            <!-- Form -->
            <form action="{{ route('resource.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="TITLE" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="DESCRIPTION"></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File</label>
                    <input type="file" class="form-control" id="file" name="FILE" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="PRICE" min="0" step="0.01">
                </div>
                <button type="submit" class="btn btn-success">Add resource</button>
            </form>
        </div>
    </div>
</div>
@endsection
