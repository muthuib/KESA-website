<!-- CSS for Carousel -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- JS for Carousel -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Collaborations Section -->
@if($collaborations->isNotEmpty())
    <div class="container mt-5">
        <h3 class="text-center">Our Partners and Collaborators</h3>
        
        <!-- Carousel -->
        <div id="collaborationCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($collaborations->chunk(4) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $collaboration)
                                <div class="col-md-3 text-center mb-4">
                                    <!-- Logo with fallback -->
                                    <img src="{{ file_exists(public_path('storage/' . $collaboration->LOGO_PATH)) 
                                                ? asset('storage/' . $collaboration->LOGO_PATH) 
                                                : asset('images/default-logo.png') }}" 
                                         alt="{{ $collaboration->NAME }}" 
                                         class="img-fluid mb-3" style="max-height: 50px; object-fit: contain;">
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
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <a class="carousel-control-prev" href="#collaborationCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#collaborationCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
@else
    <div class="container mt-5">
        <h3 class="text-center">Our Collaborations</h3>
        <p class="text-center text-muted">No collaborations available at the moment.</p>
    </div>
@endif
