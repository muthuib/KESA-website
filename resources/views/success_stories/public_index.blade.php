@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fc;
    }

    /* === HEADER SECTION === */
    .stories-header {
        text-align: center;
        color: #111;
        margin-bottom: 2.5rem;
    }

    .stories-header h2 {
        font-weight: 700;
        font-size: 2.2rem;
    }

    .stories-header p {
        color: #555;
        font-size: 1.05rem;
    }

    /* === SEARCH BAR === */
    .search-bar {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        width: 100%;
        padding: 0 1rem;
    }

    .search-bar form {
        width: 70%;
        max-width: 700px;
    }

    .search-input {
        width: 100%;
        border-radius: 50px;
        border: 2px solid #007bff;
        font-size: 1.1rem;
        /* padding: 14px 22px; */
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .search-input:focus {
        box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
        border-color: #0056b3;
    }

    /* === STORY GRID === */
    .stories-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.8rem;
    }

    @media (max-width: 992px) {
        .stories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stories-grid {
            grid-template-columns: 1fr;
        }

        .search-bar form {
            width: 90%;
        }

        .search-input {
            font-size: 1rem;
            padding: 12px 18px;
        }
    .stories-header h2 {
            font-weight: 700;
            font-size: 1.5rem;
        }
    }

    /* === STORY CARDS === */
    .story-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        background: white;
        transition: all 0.35s ease;
        opacity: 0;
        transform: translateY(40px);
    }

    .story-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .story-card img {
        height: 230px;
        width: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: #222;
        margin-bottom: 0.6rem;
    }

    .card-text {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .btn-outline-primary {
        border-radius: 50px;
        transition: all 0.3s;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
        transform: scale(1.05);
    }

    /* === PAGINATION === */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination .page-link {
        border-radius: 50%;
        margin: 0 4px;
        color: #007bff;
    }

    .pagination .active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
</style>

<div class="container py-5">
    <!-- Header -->
    <div class="stories-header">
        <h2>🌟 Inspiring Success Stories</h2>
        <p>Explore real stories of impact and transformation from our community.</p>
    </div>

    <!-- Search -->
    <div class="search-bar">
        <form method="GET">
            <input 
                type="text" 
                name="search" 
                class="form-control search-input" 
                placeholder="Search stories..." 
                value="{{ $search }}">
        </form>
    </div>

    <!-- Stories Grid -->
    <div class="stories-grid">
        @forelse($stories as $story)
            <div class="story-card">
               @if(!empty($story->cover_image) && file_exists(public_path($story->cover_image)))
                    <img src="{{ asset($story->cover_image) }}" alt="{{ $story->title }}">
                @endif

                <div class="card-body">
                  <div class="story-header-card mb-4">
                        <h4 class="story-title mb-2">{{ $story->title }}</h4>
                        <div class="story-meta">
                            <span class="me-3">
                                <i class="far fa-calendar-alt text-primary"></i>
                                <small class="text-muted">
                                    {{ $story->published_at
                                        ? \Carbon\Carbon::parse($story->published_at)->format('F j, Y')
                                        : 'Not Published' }}
                                </small>
                            </span>
                            <span>
                                <i class="fas fa-user text-success"></i>
                                <small class="text-muted">
                                    <strong>Author:</strong> {{ $story->author ?? 'Unknown Author' }}
                                </small>
                            </span>
                        </div>
                    </div>

                    <p class="card-text">{{ Str::limit(strip_tags($story->excerpt ?? $story->body), 120) }}</p>
                    <a href="{{ route('public.success_stories.show', $story->slug) }}" class="btn btn-outline-primary btn-sm">
                        Read More →
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <p class="text-muted">No stories found. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $stories->links() }}
    </div>
</div>

<style>
.story-header-card {
    border-left: 4px solid #721138ff;
    padding-left: 15px;
    background: #f8f9fc;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,.05);
    transition: all .3s ease;
}
.story-header-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,.1);
}
.story-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #222;
}
.story-meta {
    font-size: 0.9rem;
    color: #666;
}
.story-meta i {
    margin-right: 5px;
}
</style>
<!-- Smooth Fade Animation -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.story-card');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    cards.forEach(card => observer.observe(card));
});
</script>
@endsection
