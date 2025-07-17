@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold" style="margin-top: 65px;">📝 Latest Blog Posts</h2>

    <!-- Search Form -->
    <form action="{{ route('blog.display') }}" method="GET" class="mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="input-group input-group-sm shadow-sm">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control rounded-start-pill px-3"
                        placeholder="Search blog...">
                    <button class="btn btn-dark rounded-end-pill px-4" type="submit">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if($blogs->count())
        <div class="row g-4">
            @foreach($blogs as $item)
                <div class="col-md-4 d-flex">
                    <div class="card shadow-sm border-0 rounded-4 w-100 hover-shadow transition d-flex flex-column">
                        @if($item->image)
                        <img src="{{ asset($item->image) }}" class="card-img-top rounded-top-4 bg-light"
                            style="height: 200px; object-fit: contain; padding: 10px;">

                        @endif
                        <div class="card-body d-flex flex-column px-4 pt-3 pb-4">
                            <h6 class="card-title fw-semibold mb-2 small">{{ $item->title }}</h6>
                            <p class="text-muted mb-3 small">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                            </p>
                            <div class="card-text text-muted small mb-4" style="flex: 1;">
                                {{ Str::limit(strip_tags($item->content), 130, '...') }}
                            </div>
                            <a href="{{ route('blog.show', $item->id) }}" class="btn btn-sm btn-outline-primary w-100 mt-auto rounded-pill">
                                <i class="fas fa-eye me-1"></i> Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                {{ $blogs->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    @else
        <div class="alert alert-info text-center mt-5">
            <i class="fas fa-info-circle me-2"></i> No blog posts found. Updates will be made soon — keep checking.
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .card-title {
        font-size: 0.95rem;
    }

    .card-text {
        font-size: 0.87rem;
    }

    @media (max-width: 768px) {
        .input-group .form-control {
            border-radius: 50px 0 0 50px !important;
        }

        .input-group .btn {
            border-radius: 0 50px 50px 0 !important;
        }
    }
</style>
@endsection
