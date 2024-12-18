@extends('layouts.app')

@section('content')

<!-- Main Content Container -->
<div class="container mt-5 px-3" style="margin-left: 0; margin-right: 0; height: auto;">
    <!-- Main Row -->
    <div class="row align-items-center g-3">
        <!-- Logo -->
        <div class="col-12 col-md-3 d-flex justify-content-start">
            <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" 
                 style="width: 200px; margin-top: 25px;" class="img-fluid">
        </div>

        <!-- Text Section -->
        <div class="col-12 col-md-9">
            <h1 class="display-6 fw-bold text-md-start text-center" 
                style="font-size: 20px; margin: 0; margin-left: 0;">
                Welcome to Kenya Economics Students Association
            </h1>
            <p class="lead text-md-start text-center mt-2" style="margin: 0;">
                Explore our content, events, and resources. Stay updated with the latest news and debates!
            </p>
        </div>
    </div>
</div>



<!-- Slideshow outside the container for full-screen width -->
@if($slides->isNotEmpty())
<div id="guestSlideshow" 
     class="carousel slide shadow-lg" 
     data-bs-ride="carousel" 
     style="width: 100%; height: 60vh; margin-left: 0px;">
    
    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach ($slides as $index => $slide)
        <button type="button" 
                data-bs-target="#guestSlideshow" 
                data-bs-slide-to="{{ $index }}" 
                class="{{ $index === 0 ? 'active' : '' }}" 
                aria-current="true" 
                aria-label="Slide {{ $index + 1 }}">
        </button>
        @endforeach
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        @foreach ($slides as $index => $slide)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <!-- Overlay -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); "></div>    
            <!-- Slide Image -->
            <img src="{{ asset($slide->IMAGE_PATH) }}" 
                 class="d-block w-100" 
                 alt="Slide Image" 
                 style="height: 100vh; object-fit: cover; z-index: 1;">
            
            <!-- Caption -->
            <div class="carousel-caption text-left d-flex align-items-center justify-content-start h-100" style="z-index: 3;">
                <div>
                    <h2 class="text-light bg-dark bg-opacity-75 px-3 py-2 rounded">{{ $slide->CAPTION }}</h2>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" 
            type="button" 
            data-bs-target="#guestSlideshow" 
            data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" 
            type="button" 
            data-bs-target="#guestSlideshow" 
            data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@else
<!-- No Slides Message -->
<div class="alert alert-info text-center mt-4" role="alert">
    <h4 class="alert-heading">No Slides Available</h4>
    <p>Our homepage layout is being updated. Continue exploring our platform, and thank you for your patience!</p>
</div>
@endif

<!-- Newsletter Subscription Section -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm" style="margin-top: 150px;">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Subscribe to Our Newsletter</h4>
                    
                    <!-- Display error message if email is already subscribed -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('subscribe') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Your Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thank You Modal -->
@if(session('success'))
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thankYouModalLabel">Subscription Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Explore Section -->
<div class="container mt-5" style="margin-left: 0px; margin-right: 0px;">
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-newspaper fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">News & Updates</h5>
                    <p class="card-text">Stay informed with the latest happenings in our community.</p>
                    <a href="{{ route('app') }}" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Events & Debates</h5>
                    <p class="card-text">Join upcoming events and engage in enriching discussions.</p>
                    <a href="{{ route('app') }}" class="btn btn-success">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Resources</h5>
                    <p class="card-text">Access valuable resources to enhance your knowledge and skills.</p>
                    <a href="{{ route('resources.show') }}" class="btn btn-warning">Get Resources</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection