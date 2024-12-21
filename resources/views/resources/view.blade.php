@extends('layouts.app')

@section('content')
<div class="container">
         <!-- Back button with a backward icon -->
         <div class="mb-3 text-end">
        <a href="{{ route('resources.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    <!-- Card with margin-left for spacing -->
   <div class="card" style="margin-left: 0px; width: 900px; top: 40px;">
        <div class="card-header">
            <h3>{{ $resource->TITLE }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $resource->DESCRIPTION }}</p>
            <p><strong>Price:</strong> Ksh. {{ number_format($resource->PRICE, 2) }}</p>
            <p><strong>Type:</strong>  {{$resource->TYPE }}</p>

            <!-- Display Resource Image (click to enlarge) -->
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
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('resources.edit', $resource->ID) }}" class="btn btn-primary">Edit Resource</a>
        </div>
    </div>
</div>
@endsection