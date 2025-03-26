@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="margin-top: 100px;">Publications</h1>
    <p style="font-size: 17px;">Welcome to the KESA Publications Hub, The Economics Students Association of Kenya (KESA) is dedicated to fostering knowledge, innovation, and thought leadership among economics students and professionals. Our Publications Hub serves as a dynamic resource center, offering insights into economic trends, research findings, and industry advancements.</p>
    <p style="font-size: 17px;">At KESA, we believe in the power of knowledge to drive economic progress and empower individuals. Our diverse range of publications is designed to inform, educate, and inspire students, professionals, and enthusiasts who are passionate about economics and its role in shaping societies.</p>
    <div class="card shadow-sm">
        <div class="card-body">
        <p style="text-align: center; font-size: 25px; font-weight: bold; color: black;">Latest Publications</p>
        @forelse($publications as $publication)
    <!-- Publication Row -->
    <div class="row align-items-center mb-3 publication-row">
        <!-- Icon Column -->
        <div class="col-md-1 text-center">
            <i class="fas fa-file-alt text-brown publication-icon"></i>
        </div>

        <!-- Title Column -->
        <div class="col-md-6">
            <h5 class="mb-0 publication-title">{{ $publication->title }}</h5>
        </div>

        <!-- Uploaded Date Column -->
        <div class="col-md-3">
            <p class="mb-0 publication-date">
                Uploaded on {{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}
            </p>
        </div>

        <!-- Download Button Column -->
        <div class="col-md-2 text-end">
            <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-primary btn-sm">
                Download
            </a>
        </div>
    </div>
     <!-- Animated Brown Line Divider -->
     <div class="animated-line"></div>
@empty
    <p class="text-center text-muted">No publications available.</p>
@endforelse

        </div>
    </div>
</div>

<!-- Animated line styling -->
<style>
    .animated-line {
        height: 1px;
        background-color: brown;
        width: 0;
        animation: growLine 1s forwards;
        margin: 20px 0;
    }
    @keyframes growLine {
        from { width: 0; }
        to { width: 100%; }
    }
    @media (max-width: 992px) { /* Targets medium and small screens */
    h1 {
        font-size: 24px !important;
    }
    p {
        font-size: 14px !important;
    }
    .btn-sm {
        font-size: 12px !important;
        padding: 5px 10px;
    }
}

@media (max-width: 576px) { /* Targets extra small screens */
    h1 {
        font-size: 20px !important;
    }
    p {
        font-size: 12px !important;
    }
    .btn-sm {
        font-size: 10px !important;
        padding: 4px 8px;
    }
}
/* Default styles for large screens */
.publication-title {
    font-size: 1.2rem; /* Default size */
    font-weight: bold;
}

.publication-date {
    font-size: 1rem;
    color: #555;
}

.publication-icon {
    font-size: 24px;
    color: brown;
}

/* Responsive Styles */
@media (max-width: 992px) { /* Medium screens (Tablets) */
    .publication-title {
        font-size: 1rem;
    }
    .publication-date {
        font-size: 0.9rem;
    }
    .publication-icon {
        font-size: 20px;
    }
}

@media (max-width: 768px) { /* Small screens (Phones) */
    .publication-title {
        font-size: 0.9rem;
    }
    .publication-date {
        font-size: 0.8rem;
    }
    .publication-icon {
        font-size: 18px;
    }
}

</style>
@endsection