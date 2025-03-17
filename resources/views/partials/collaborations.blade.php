<!-- Collaborations Section -->
@if($collaborations->isNotEmpty())
    <div class="container mt-5">
        <h3 class="text-center">Our Partners and Collaborators</h3>
        
        <!-- Static Grid for First Few Collaborators -->
        <div class="row mt-4">
            @foreach ($collaborations->take(4) as $collaboration) <!-- Display first 4 in static grid -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <!-- Logo with fallback -->
                            <img src="{{ file_exists(public_path($collaboration->LOGO_PATH)) 
                                    ? asset($collaboration->LOGO_PATH) 
                                    : asset('images/default-logo.png') }}" 
                            alt="{{ $collaboration->NAME }}" 
                            class="img-fluid mb-3" 
                            style="max-height: 100px; object-fit: contain;">
                            <!-- Name -->
                            <h5 class="card-title">{{ $collaboration->NAME ?? 'Unknown Partner' }}</h5>
                            <!-- Description -->
                            <p class="card-text text-muted">
                                {{ $collaboration->DESCRIPTION ?? 'No description available.' }}
                            </p>
                            <!-- Website -->
                            @if(!empty($collaboration->WEBSITE))
                                <a href="{{ $collaboration->WEBSITE }}" 
                                   class="btn btn-outline-primary btn-sm mt-auto" 
                                   target="_blank">Visit Website</a>
                            @else
                                <span class="text-muted">No website available</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Marquee for Extra Collaborators -->
        @if($collaborations->count() > 4)
            <div class="mt-4">
                <h4 class="text-center">More Collaborators</h4>
                <div style="overflow: hidden; white-space: nowrap; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">
                    <marquee behavior="scroll" direction="left" scrollamount="4">
                        @foreach ($collaborations->slice(4) as $collaboration) <!-- Display extra collaborators -->
                            <div style="display: inline-block; text-align: center; margin-right: 30px;">
                                <!-- Logo -->
                                <img src="{{ file_exists(public_path($collaboration->LOGO_PATH)) 
                                        ? asset($collaboration->LOGO_PATH) 
                                        : asset('images/default-logo.png') }}" 
                                alt="{{ $collaboration->NAME }}" 
                                class="img-fluid mb-3" 
                                style="max-height: 50px; object-fit: contain;">

                                <!-- Name -->
                                <p class="mt-2" style="font-size: 14px;">{{ $collaboration->NAME ?? 'Unknown Partner' }}</p>
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
