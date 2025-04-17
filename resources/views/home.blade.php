@extends('layouts.app')

<!-- Custom CSS -->
<style>
    /* Default Styles for Large Screens */
    .logo-img {
        width: 200px;
        margin-top: 30px;
        margin-right: 15px; /* Add space between logo and text */
    }

    .text-content {
        display: flex;
        flex-direction: column; /* Stack text content vertically */
    }

    .heading-text {
        font-size: 18px !important;
        margin-left: 200px;
        margin-top: 40px;
        margin-bottom: 0px; /* Reduce space below h1 */
    }

    .description-text {
        font-size: 14px;
        margin-left: 150;
        margin-top: 0px; /* Reduce space above p */
    }

    /* Responsive Styles */
    @media (max-width: 768px) { /* Apply styles for small devices */
        .logo-img {
            width: 100px; /* Reduce logo size */
            margin-top: 35;
            margin-right: 1px;
            margin-left: 3px;
        }

        .heading-text {
            font-size: 10px !important; /* Reduce heading font size */
            margin-top: 35;
            margin-left: 3px;
        }

        .description-text {
            font-size: 8px !important; /* Reduce paragraph font size */
            margin-left: 3px;
        }

        .text-content {
            flex: 1; /* Allow text to use remaining space */
        }
    }

    @media (max-width: 400px) { /* Apply even smaller styles for extra-small devices */
        .heading-text {
            font-size: 8px !important; 
            margin-left: 3px;
        }

        .description-text {
            font-size: 7px !important;
            margin-left: 3px;
        }
    }
    /* device responsiveness for slideshows */
    /* Default for large screens */
#guestSlideshow {
    width: 100%;
    height: 60vh; /* Adjusted for better proportionality */
}

#guestSlideshow .carousel-item img {
    height: 100vh;
    object-fit: cover;
}

/* Medium screens (tablets) */
@media (max-width: 992px) {
    #guestSlideshow {
        height: 40vh; /* Reduce height */
    }

    #guestSlideshow .carousel-item img {
        height: 40vh;
    }

    #guestSlideshow .carousel-caption h2 {
        font-size: 20px; /* Reduce caption size */
    }
}

/* Small screens (mobile) */
@media (max-width: 576px) {
    #guestSlideshow {
        height: 20vh; /* Further reduce height */
    }

    #guestSlideshow .carousel-item img {
        height: 20vh;
    }

    #guestSlideshow .carousel-caption {
        text-align: center;
        bottom: 10px; /* Adjust caption position */
    }

    #guestSlideshow .carousel-caption h2 {
        font-size: 16px; /* Make text smaller */
        padding: 5px 10px;
    }
}
#guestSlideshow {
    width: 100%;
    height: 100vh; /* Ensures it covers the full screen */
    margin-top: 90px; /* Default for large screens */
}

/* Adjust margin-top for small and medium screens */
@media (max-width: 991px) { /* Bootstrap lg breakpoint */
    #guestSlideshow {
        margin-top: 60px;
        height: 60vh; /* Adjust height for better fit */
    }
}


</style>

<!-- Slideshow outside the container for full-screen width -->
@if($slides->isNotEmpty())
<div id="guestSlideshow" 
     class="carousel slide shadow-lg" 
     data-bs-ride="carousel" 
     style="width: 100%; height: 60vh;">
    
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
                 style="height: 100vh; object-fit: cover; z-index: 1; width: 100vw; height: 100vh;">
            
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
 <!-- impacts Section -->
 @php
    $impact = App\Models\Impact::first();
@endphp
@include('impacts._overview', ['impact' => App\Models\Impact::first() ?? (object)[
    'total_people' => 0,
    'total_events' => 0,
    'total_trainings' => 0
]])

@section('scripts')

<script>
    function animateCount(id, endValue, duration = 1500) {
        const element = document.getElementById(id);
        let start = 0;
        const stepTime = Math.abs(Math.floor(duration / endValue));

        const timer = setInterval(() => {
            start++;
            element.textContent = start.toLocaleString();

            if (start >= endValue) clearInterval(timer);
        }, stepTime);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Check if the impact data exists, otherwise use 0 as the default value
        animateCount('totalPeople', {{ $impact->total_people ?? 0 }});
        animateCount('totalEvents', {{ $impact->total_events ?? 0 }});
        animateCount('totalTrainings', {{ $impact->total_trainings ?? 0 }});
    });
</script>

@endsection


    <!-- memberships Section -->
    @include('partials.memberships', ['memberships' => App\Models\Membership::all()])
<!-- Collaborations Section -->
    @include('partials.collaborations', ['collaborations' => App\Models\Collaboration::all()])

<!-- What People Say About Us Section -->
@include('testimonials.display', ['testimonials' => App\Models\Testimonial::latest()->get()])






