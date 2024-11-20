@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $resource->TITLE }}</h1>
    <p><strong>Description:</strong> {{ $resource->DESCRIPTION }}</p>
    <p><strong>Price:</strong> {{ $resource->PRICE > 0 ? '$' . $resource->PRICE : 'Free' }}</p>

    <!-- File Download -->
    <a href="{{ asset('storage/' . $resource->FILE_PATH) }}" class="btn btn-primary" download>Download File</a>
</div>
@endsection
