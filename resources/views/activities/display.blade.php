@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-bottom: 30px;">
    <h2 class="mb-4 text-center fw-bold" style="margin-top: 5px;">ðŸ“… Our Past Events and Activities</h2>

    <!-- Search Form -->
    <form action="{{ route('activities.display') }}" method="GET" class="mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="input-group flex-nowrap">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control shadow-sm rounded-start-pill"
                        placeholder="Search past events...">
                    <button class="btn btn-dark rounded-end-pill px-4" type="submit">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if($activities->count())
        <div class="row g-4">
            @foreach($activities as $activity)
                <div class="col-md-4 d-flex">
                    <div class="card shadow-sm border-0 rounded-4 w-100 d-flex flex-column hover-shadow transition">
                        @if($activity->media)
                            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                                <video class="card-img-top rounded-top-4" style="height: 200px; object-fit: contain;" controls>
                                    <source src="{{ asset($activity->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <img src="{{ asset($activity->media) }}" class="card-img-top rounded-top-4" style="height: 200px; object-fit: contain;">
                            @endif
                        @endif
                        <div class="card-body d-flex flex-column px-4 pt-3 pb-4">
                            <h5 class="card-title fw-semibold mb-2"style = "color: black;">{{ $activity->title }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::parse($activity->date)->format('l, F d, Y') }}
                            </p>
                            <div class="card-text mb-4" style="flex: 1;">
                                {{ Str::limit(strip_tags($activity->description), 130, '...') }}
                            </div>
                            <a href="{{ route('events.view', $activity->id) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill">
                                <i class="fas fa-eye me-2"></i> Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Styled Pagination -->
        <div class="mt-5">
            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                {{ $activities->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    @else
        <div class="alert alert-info text-center mt-5">
            <i class="fas fa-info-circle me-2"></i> No past events available at the moment.
        </div>
    @endif
</div>

<!-- Optional Hover Effect Style -->
<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    @media (max-width: 768px) {
        .input-group {
            flex-wrap: nowrap;
        }

        .input-group .form-control {
            border-radius: 50px 0 0 50px !important;
        }

        .input-group .btn {
            border-radius: 0 50px 50px 0 !important;
        }
    }
</style>
@endsection