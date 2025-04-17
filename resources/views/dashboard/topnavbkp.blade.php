@extends('layouts.app')

@section('content')
@auth
    <div class="d-flex justify-content-between align-items-left mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('activity.index') }}" class="btn btn-dark" style="margin-top: 5px;">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>
@endauth

<!-- Full-width header with secondary background -->
<div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '120px' }}; margin-bottom: 8px; background-color: rgb(244, 237, 237);">
    <div class="container-fluid px-4">
        <h2 class="mb-0 news-title w-100">{{ $activity->title }}</h2>
    </div>
</div>

<div class="container mt-5">
    <div class="news-detail">
        @if($activities->image)
            <img src="{{ asset($news->image) }}" class="news-image mb-3" alt="News Image">
        @endif

        <p class="text-left text-muted">
            <strong>{{ \Carbon\Carbon::parse($activities->date)->format('l, F j, Y') }}</strong>
        </p>

        <div class="mt-3 news-content" style="line-height: 1.7; font-size: 1.1rem; text-align: left;">
            {!! $activities->description !!}
        </div>
    </div>
</div>

<!-- Responsive Styling -->
<style>
    .news-image {
        max-width: 60%;
        height: auto;
        float: left;
        margin-right: 1rem;
    }

    .news-title {
        text-align: left;
        font-size: 32px;
        font-weight: bold;
        padding: 0px 0;
    }

    @media (max-width: 992px) {
        .responsive-header {
            margin-top: 90px !important;
        }
        .news-title {
            font-size: 24px;
        }
    }

    @media (max-width: 768px) {
        .news-image {
            float: none !important;
            max-width: 100% !important;
            margin-right: 0 !important;
            display: block;
        }

        .news-content {
            text-align: left;
        }

        .news-title {
            font-size: 18px;
        }
    }
</style>
@endsection
