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

/* Modern Slideshow Enhancements */
.slide-img {
    width: 100%;
    margin-top: 100px;
    height: 100vh;
    animation: zoomIn 10s ease-in-out infinite alternate;
    filter: brightness(70%); /* Makes slide darker underneath overlay */
}

.caption-box {
    background: rgba(0, 0, 0, 0.6);
    padding: 20px 30px;
    border-radius: 12px;
    backdrop-filter: blur(5px);
}
.animate-caption {
    animation: fadeInUp 2s ease;
}

/* Animations */
@keyframes zoomIn {
    from {
        transform: scale(1);
    }
    to {
        transform: scale(1.1);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive height fixes */
@media (max-width: 768px) {
    .slide-img {
    width: 100%;
    margin-top: 75px;
    height: 50vh;
    animation: zoomIn 10s ease-in-out infinite alternate;
    filter: brightness(70%); /* Makes slide darker underneath overlay */
}
}

@media (max-width: 576px) {
    .slide-img {
    width: 100%;
    margin-top: 75px;
    height: 50vh;
    animation: zoomIn 10s ease-in-out infinite alternate;
    filter: brightness(70%); /* Makes slide darker underneath overlay */
}

    .caption-box {
        padding: 10px 15px;
    }

    .caption-box h2 {
        font-size: 18px;
    }
}

/* Impact Overview Section */
.impact-overview {
    position: relative;
    /* background: rgba(0, 0, 0, 0.5); Semi-transparent background */
    color: white;
    padding: 0px;
    display: flex;
    align-items: center;
    z-index: 2; /* stays above background */
    margin-top: -200px; /* pull it up over the slides */
    width: 100%;
}


.impact-item {
    text-align: center;
}

.impact-item h3 {
    margin: 0;
    font-size: 18px;
}

.impact-item p {
    font-size: 16px;
    margin: 5px 0;
}
/* Small and Medium screens */
@media (max-width: 992px) { /* 992px is Bootstrap's 'md' breakpoint */
    .impact-overview {
        margin-top: -50px;
        margin-bottom: 0px;
    }
}
.memberships-wrapper {
    margin-top: 0px; /* Default spacing on large screens */
     padding: 0; /* Ensure no padding */
}

/* Remove margin on small/medium screens */
@media (max-width: 992px) {
    .memberships-wrapper {
        margin-top: 0px;
         padding: 0; /* Ensure no padding */
    }
}


</style>

    <!-- Slides -->
<!-- Slideshow with Modern Design -->
@if($slides->isNotEmpty())
<div id="guestSlideshow" 
     class="carousel slide carousel-fade shadow-lg" 
     data-bs-ride="carousel"
     data-bs-interval="5000">

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
            <img src="{{ asset($slide->IMAGE_PATH) }}" 
                 class="d-block w-100 slide-img" 
                 alt="Slide Image">
            <div class="carousel-caption d-flex align-items-center justify-content-start h-100">
                <div class="caption-box animate-caption">
                    <h2 class="text-light m-0">{{ $slide->CAPTION }}</h2>
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
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" 
            type="button" 
            data-bs-target="#guestSlideshow" 
            data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

@else
<!-- No Slides Message -->
<div class="alert alert-info text-center mt-4" role="alert">
    <h4 class="alert-heading" style="margin-top: 100px;">No Slides Available</h4>
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
<div class="impact-overview">
@include('impacts._overview', ['impact' => App\Models\Impact::first() ?? (object)[
    'total_people' => 0,
    'total_events' => 0,
    'total_trainings' => 0
]])
</div>

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
   <div class="memberships-wrapper" style = "margin-top: 0px;">
    @include('partials.memberships', ['memberships' => App\Models\Membership::all()])
    </div>

<!-- Collaborations Section -->
    @include('partials.collaborations', ['collaborations' => App\Models\Collaboration::all()])

<!-- What People Say About Us Section -->
@include('testimonials.display', ['testimonials' => App\Models\Testimonial::latest()->get()])






