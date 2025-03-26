@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center my-4">
        <h3>Explore Resources</h3>
    </div>

    <!-- Resources Grid -->
    <div class="row g-4 row-cols-1 row-cols-md-3">
        @forelse ($resources as $resource)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <!-- Resource Image -->
                @if($resource->FILE_PATH)
                <img src="{{ asset($resource->FILE_PATH) }}" class="card-img-top" alt="{{ $resource->TITLE }}" style="height: 200px; object-fit: cover;">
                @else
                <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="Default File" style="height: 200px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <!-- Resource Title -->
                    <h5 class="card-title">{{ $resource->TITLE }}</h5>

                    <!-- Resource Description (Truncated) -->
                    <p class="card-text text-truncate">
                        {{ Str::limit($resource->DESCRIPTION, 100) }}
                    </p>
                    <button class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#modal-{{ $resource->ID }}">
                        Read More
                    </button>

                    <!-- Price -->
                    <p class="card-text text-success fw-bold">Price: Ksh. {{ number_format($resource->PRICE, 2) }}</p>
                </div>

                <!-- Card Footer with Actions -->
                <div class="card-footer bg-white">
                    <a href="{{ route('resources.view', $resource->ID) }}" class="btn btn-sm btn-info">View</a>
                </div>
            </div>
        </div>

        <!-- Modal for Full Description -->
        <div class="modal fade" id="modal-{{ $resource->ID }}" tabindex="-1" aria-labelledby="modalLabel-{{ $resource->ID }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $resource->TITLE }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $resource->DESCRIPTION }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info" style="text-align: center;">
                No publicatins are available at the moment. Please check back later!
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if($resources->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $resources->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
