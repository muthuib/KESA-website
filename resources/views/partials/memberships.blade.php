<!-- Memberships Section -->
@if($memberships->isNotEmpty())
    <div class="container">
        <h3 style=" text-align: center; color: maroon; font-size: 30px;">Our Members</h3>
        
        <!-- Static Grid for First Few Members -->
        <div class="row">
            @foreach ($memberships->take(8) as $membership) 
                <div class="col-6 col-sm-6 col-md-3 text-center mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <!-- Centered Logo with Fallback -->
                            <div class="text-center">
                                <img src="{{ file_exists(public_path($membership->LOGO_PATH)) 
                                            ? asset($membership->LOGO_PATH) 
                                            : asset('images/default-logo.png') }}" 
                                    alt="{{ $membership->NAME }}" 
                                    class="img-fluid mb-3 membership-logo" 
                                    style="width: 70px; display: block; margin: 0 auto;">
                            </div>
                            <!-- Name -->
                            <h5 class="card-title membership-title">{{ $membership->NAME ?? 'Unknown Member' }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Marquee for Extra Members -->
        @if($memberships->count() > 8)
            <div class="mt-4">
                <h4 class="text-center">More Members</h4>
                <div class="marquee-container">
                    <marquee behavior="scroll" direction="left" scrollamount="4">
                        @foreach ($memberships->slice(8) as $membership)
                            <div class="marquee-item">
                                <img src="{{ file_exists(public_path($membership->LOGO_PATH)) 
                                        ? asset($membership->LOGO_PATH) 
                                        : asset('images/default-logo.png') }}" 
                                alt="{{ $membership->NAME }}" 
                                class="img-fluid marquee-logo" style="width: 70px; display: block; margin: 0 auto;">
                                <p class="marquee-text">{{ $membership->NAME ?? 'Unknown Member' }}</p>
                            </div>
                        @endforeach
                    </marquee>
                </div>
            </div>
        @endif
    </div>
@else
    <div class="container mt-5">
        <h3 class="text-center">Our Members</h3>
        <p class="text-center text-muted">No members available at the moment.</p>
    </div>
@endif

<style>
/* Default logo size */
.membership-logo {
    max-height: 100px;
    object-fit: contain;
}

/* Default text size */
.membership-title {
    font-size: 18px;
}

/* Reduce size on smaller screens */
@media (max-width: 576px) {
    h3 {
        font-size: 20px; /* Reduce section title size */
    }
    .membership-logo {
        max-height: 70px !important; /* Smaller logos on small devices */
    }
    .membership-title {
        font-size: 16px; /* Smaller text */
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
