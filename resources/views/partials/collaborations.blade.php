<!-- Collaborations Section -->
@if($collaborations->isNotEmpty())
    <div class="container mt-5">
        <h3 style="text-align: center; color: maroon; font-size: 30px;">Our Partners</h3>
        
        <!-- Static Grid for First Few Collaborators -->
        <div class="row mt-4">
            @foreach ($collaborations->take(8) as $collaboration) 
                <div class="col-6 col-sm-6 col-md-3 text-center mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                           <!-- Centered Logo with Fallback -->
                            <div class="text-center">
                                <img src="{{ file_exists(public_path($collaboration->LOGO_PATH)) 
                                            ? asset($collaboration->LOGO_PATH) 
                                            : asset('images/default-logo.png') }}" 
                                    alt="{{ $collaboration->NAME }}" 
                                    class="img-fluid mb-3 collaboration-logo" 
                                    style="width: 70px; display: block; margin: 0 auto;">
                            </div>
                            <!-- Name -->
                            <h5 class="card-title collaboration-title">{{ $collaboration->NAME ?? 'Unknown Partner' }}</h5>

                            <!-- Description -->
                            <!-- <p class="card-text text-muted collaboration-description">
                                {{ $collaboration->DESCRIPTION ?? 'No description available.' }}
                            </p> -->

                            <!-- Website -->
                            <!-- @if(!empty($collaboration->WEBSITE))
                                <a href="{{ $collaboration->WEBSITE }}" 
                                   class="btn btn-outline-primary btn-sm mt-auto" 
                                   target="_blank">Visit Website</a>
                            @else
                                <span class="text-muted small">No website available</span>
                            @endif -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Marquee for Extra Collaborators -->
        @if($collaborations->count() > 8)
            <div class="mt-4">
                <h4 class="text-center">More Collaborators</h4>
                <div class="marquee-container">
                    <marquee behavior="scroll" direction="left" scrollamount="4">
                        @foreach ($collaborations->slice(8) as $collaboration)
                            <div class="marquee-item">
                                <img src="{{ file_exists(public_path($collaboration->LOGO_PATH)) 
                                        ? asset($collaboration->LOGO_PATH) 
                                        : asset('images/default-logo.png') }}" 
                                alt="{{ $collaboration->NAME }}" 
                                class="img-fluid marquee-logo">
                                <p class="marquee-text">{{ $collaboration->NAME ?? 'Unknown Partner' }}</p>
                            </div>
                        @endforeach
                    </marquee>
                </div>
            </div>
        @endif
    </div>
@else
    <div class="container mt-5">
        <h3 class="text-center">Our Collaborations</h3>
        <p class="text-center text-muted">No collaborations available at the moment.</p>
    </div>
@endif

<style>
    /* Default logo size */
.collaboration-logo {
    max-height: 100px;
    object-fit: contain;
}

/* Default text size */
.collaboration-title {
    font-size: 18px;
}
.collaboration-description {
    font-size: 14px;
}

/* Reduce size on smaller screens */
@media (max-width: 576px) {
    h3 {
        font-size: 20px; /* Reduce section title size */
    }
    .collaboration-logo {
        max-height: 70px !important; /* Smaller logos on small devices */
    }
    .collaboration-title {
        font-size: 16px; /* Smaller text */
    }
    .collaboration-description {
        font-size: 12px; /* Adjust description */
    }
    .marquee-logo {
        max-height: 40px !important; /* Smaller marquee logos */
    }
    .marquee-text {
        font-size: 12px; /* Smaller text in marquee */
    }
}

/* Marquee styling */
.marquee-container {
    overflow: hidden;
    white-space: nowrap;
    background: #f8f9fa;
    padding: 10px;
    border: 1px solid #ddd;
}
.marquee-item {
    display: inline-block;
    text-align: center;
    margin-right: 30px;
}
.marquee-logo {
    max-height: 50px;
    object-fit: contain;
}
.marquee-text {
    font-size: 14px;
    text-align: center;
}

</style>