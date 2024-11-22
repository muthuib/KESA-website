@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card with margin-left for spacing -->
   <div class="card" style="margin-left: 0px; width: 900px; top: 40px;">
        <div class="card-header">
            <h5 class="mb-0">Edit Resource</h5>
        </div>
        <div class="card-body">
            <!-- Pass the $resource instance to the update route -->
            <form action="{{ route('resources.update', $resource->ID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="TITLE" class="form-label">Title</label>
                    <input type="text" name="TITLE" id="TITLE" class="form-control"
                        value="{{ old('TITLE', $resource->TITLE) }}" required>
                    @error('TITLE')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="DESCRIPTION" class="form-label">Description</label>
                    <textarea name="DESCRIPTION" id="DESCRIPTION"
                        class="form-control">{{ old('DESCRIPTION', $resource->DESCRIPTION) }}</textarea>
                    @error('DESCRIPTION')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="FILE_PATH" class="form-label">Resource Image</label>
                    <input type="file" name="FILE_PATH" id="FILE_PATH" class="form-control">
                    @error('FILE_PATH')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!-- Display existing image if available -->
                    @if($resource->FILE_PATH)
                    <div class="mt-2">
                        <img src="{{ asset($resource->FILE_PATH) }}" alt="Current Image" width="150">
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="PRICE" class="form-label">Price</label>
                    <input type="number" step="0.01" name="PRICE" id="PRICE" class="form-control"
                        value="{{ old('PRICE', $resource->PRICE) }}" required>
                    @error('PRICE')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('resources.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection