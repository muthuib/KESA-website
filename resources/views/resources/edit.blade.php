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
                    <label for="TITLE" class="form-label fw-bold">TITLE</label>
                    <input type="text" name="TITLE" id="TITLE" class="form-control"
                        value="{{ old('TITLE', $resource->TITLE) }}" required>
                    @error('TITLE')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="DESCRIPTION" class="form-label fw-bold">DESCRIPTION</label>
                    <textarea name="DESCRIPTION" id="DESCRIPTION"
                        class="form-control">{{ old('DESCRIPTION', $resource->DESCRIPTION) }}</textarea>
                    @error('DESCRIPTION')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
      <!-- file display -->
                <div class="mb-3">
                        <label for="FILE_PATH" class="form-label fw-bold">RESOURCE FILE</label>
                        <input type="file" name="FILE_PATH" id="FILE_PATH" class="form-control">
                        @error('FILE_PATH')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <!-- Display existing image if available -->
                        @if($resource->FILE_PATH)
                        <div class="mt-2">
                        @if ($resource->FILE_PATH)
                        @php
                            $extension = pathinfo($resource->FILE_PATH, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif', 'svg']))
                            <!-- Display image -->
                            <img src="{{ asset($resource->FILE_PATH) }}" alt="Current File" width="100">
                        @elseif ($extension === 'pdf')
                            <!-- Display link to the PDF -->
                            <a href="{{ asset($resource->FILE_PATH) }}" target="_blank">View PDF</a>
                        @elseif (in_array($extension, ['mp4']))
                            <!-- Display video -->
                            <video width="320" height="240" controls>
                                <source src="{{ asset($resource->FILE_PATH) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <!-- Handle other file types -->
                            <a href="{{ asset($resource->FILE_PATH) }}" target="_blank">Download File</a>
                        @endif
                    @endif
                        </div>
                        @endif
                </div>
     <!-- end of file display -->
                <div class="mb-3">
                    <label for="PRICE" class="form-label fw-bold">PRICE</label>
                    <input type="number" step="0.01" name="PRICE" id="PRICE" class="form-control"
                        value="{{ old('PRICE', $resource->PRICE) }}" required>
                    @error('PRICE')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="TYPE" class="form-label fw-bold">TYPE</label>
                    <select name="TYPE" id="TYPE" class="form-control" required>
                        <option value="" disabled>Select Type</option>
                        <option value="pdf" 
                            {{ old('TYPE', $resource->TYPE ?? '') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" 
                            {{ old('TYPE', $resource->TYPE ?? '') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="article" 
                            {{ old('TYPE', $resource->TYPE ?? '') == 'article' ? 'selected' : '' }}>Article</option>
                    </select>
                    @error('TYPE')
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