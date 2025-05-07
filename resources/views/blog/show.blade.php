@extends('layouts.app')

@section('content')
@auth
    <div class="d-flex justify-content-between align-items-left mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('blog.index') }}" class="btn btn-dark" style="margin-top: 5px;">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>
@endauth

<!-- Full-width header with secondary background -->
<div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '120px' }}; margin-bottom: 8px; background-color: rgb(243, 233, 233);">
    <div class="container-fluid px-4">
        <h2 class="mb-0 blog-title w-100">{{ $blog->title }}</h2>
    </div>
</div>

<div class="container mt-5">
    <div class="blog-detail">
        @if($blog->image)
            <img src="{{ asset($blog->image) }}" class="blog-image mb-3" alt="Blog Image">
        @endif

        <p class="text-left text-muted">
            <strong>{{ \Carbon\Carbon::parse($blog->date)->format('l, F j, Y') }}</strong>
        </p>

        <div class="mt-3 blog-content" style="line-height: 1.7; font-size: 1.1rem; text-align: left;">
            {!! $blog->content !!}
        </div>
    </div>
</div>

<!-- Responsive Styling -->
<style>
    .blog-image {
        max-width: 60%;
        height: auto;
        float: left;
        margin-right: 1rem;
    }

    .blog-title {
        text-align: left;
        font-size: 32px;
        font-weight: bold;
        padding: 0px 0;
    }

    .blog-content a {
        color: #007bff !important; /* Using a shade of blue */
        text-decoration: none !important; /* Remove underline */
    }

    .blog-content a:hover {
        text-decoration: underline !important; /* Underline on hover */
        color: #0056b3 !important; /* Darker blue on hover */
    }

    @media (max-width: 992px) {
        .responsive-header {
            margin-top: 90px !important;
        }
        .blog-title {
            font-size: 24px;
        }
    }

    @media (max-width: 768px) {
        .blog-image {
            float: none !important;
            max-width: 100% !important;
            margin-right: 0 !important;
            display: block;
        }

        .blog-content {
            text-align: left;
        }

        .blog-title {
            font-size: 18px;
        }
    }
</style>
@endsection
