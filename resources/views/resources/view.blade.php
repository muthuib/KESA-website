@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card with margin-left for spacing -->
   <div class="card" style="margin-left: 0px; width: 900px; top: 40px;">
        <div class="card-header">
            <h3>{{ $resource->TITLE }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $resource->DESCRIPTION }}</p>
            <p><strong>Price:</strong> Ksh. {{ number_format($resource->PRICE, 2) }}</p>

            <!-- Display Resource Image (click to enlarge) -->
            <p><strong>File Path:</strong> {{ $resource->FILE_PATH }}</p>
            @if($resource->FILE_PATH)
            <div class="mt-3">
                <a href="{{ asset($resource->FILE_PATH) }}" target="_blank">
                    <img src="{{ asset($resource->FILE_PATH) }}" alt="Resource Image" width="300" class="img-fluid">
                </a>
            </div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('resources.index') }}" class="btn btn-secondary">Back to Resources</a>
            <a href="{{ route('resources.edit', $resource->ID) }}" class="btn btn-primary">Edit Resource</a>
        </div>
    </div>
</div>
@endsection