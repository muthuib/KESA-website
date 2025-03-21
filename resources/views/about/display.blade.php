@extends('layouts.app')

@section('content')
    <div class="container my-5" style="margin-top: 90px;">
        <div class="row">
            <!-- Left Column: Dynamic Animated Slideshow -->
            <div class="col-lg-6 col-md-12 mb-4" style="margin-top: 70px;">
                @if($slides->isNotEmpty())
                    <div id="aboutSlideshow" class="carousel slide shadow-lg" data-bs-ride="carousel" data-bs-interval="4000">
                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators">
                            @foreach($slides as $index => $slide)
                                <button type="button" data-bs-target="#aboutSlideshow" data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" 
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <!-- Carousel Items -->
                        <div class="carousel-inner">
                            @foreach($slides as $index => $slide)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($slide->IMAGE_PATH) }}" class="d-block w-100 slideshow-img" 
                                        alt="Slide Image">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $slide->CAPTION }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#aboutSlideshow" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#aboutSlideshow" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <p>No slides available</p>
                    </div>
                @endif
            </div>
            
            <!-- Right Column: About Us Content -->
            <div class="col-lg-6 col-md-12">
                <div class="about-section">
                    <h3 class="text-center mb-3" style="margin-top: 40px;">About Us</h3>
                    <div class="quill-content">
                        {!! $about->ABOUT ?? '<p class="text-center">About not set yet.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Sections: Vision, Mission, Motto, Belief, Objectives -->
    <div class="container">
        <div class="container my-5" style="margin-top: 90px; width: 600px; text-align:center;">
        <div class="animated-line"></div>
            <!-- Vision Section -->
            <div class="about-section">
                <h3 class="text-center mb-3">Our Vision</h3>
                <div class="quill-content">
                    {!! $about->VISION ?? '<p class="text-center">Vision not set yet.</p>' !!}
                </div>
            </div>
            <div class="animated-line my-5"></div>

            <!-- Mission Section -->
            <div class="about-section">
                <h3 class="text-center mb-3">Our Mission</h3>
                <div class="quill-content">
                    {!! $about->MISSION ?? '<p class="text-center">Mission not set yet.</p>' !!}
                </div>
            </div>
            <div class="animated-line my-5"></div>

            <!-- Motto Section -->
            <div class="about-section">
                <h3 class="text-center mb-3">Our Motto</h3>
                <div class="quill-content">
                    {!! $about->MOTTO ?? '<p class="text-center">Motto not set yet.</p>' !!}
                </div>
            </div>
            <div class="animated-line my-5"></div>
             <!-- Objectives Section -->
           <!-- Objectives Section -->
<div class="about-section">
    <h3 class="text-left mb-3">Our Objectives</h3>
    <div class="quill-content text-left">
        {!! $about->OBJECTIVES ?? '<p class="text-left">Objectives not set yet.</p>' !!}
    </div>
</div>
<div class="animated-line my-5"></div>

<!-- Belief/Values Section -->
<div class="about-section">
    <h3 class="text-left mb-3">Our Values</h3>
    <div class="quill-content text-left">
        {!! $about->BELIEF ?? '<p class="text-left">Values not set yet.</p>' !!}
    </div>
</div>
<div class="animated-line my-5"></div>

        </div>
    </div>
    <!-- Responsive Styles -->
    <style>
        /* Responsive Slideshow */
        .slideshow-img {
            height: 70vh;
            object-fit: cover;
        }
            .animated-line {
            height: 4px;
            background-color: brown;
            width: 0;
            animation: growLine 2s forwards;
            margin: 30px 0;  
        } 
        @keyframes growLine {
            from { width: 0; }
            to { width: 100%; }
        }
        .quill-content {
            text-align: left !important;
        }


            @media (max-width: 767px) {
                .slideshow-img {
                    height: 40vh;
            }
        }

        /* Section Styles */
        .about-section {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Responsive Font Size */
        .quill-content {
            font-size: 1.125rem;
            line-height: 1.6;
            padding: 10px;
            color: #333;
        }

        @media (max-width: 767px) {
            .quill-content {
                font-size: 14px;
                line-height: 1.5;
            }
        }

        /* Team Member Images */
        .team-img {
            height: 200px;
            width: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto;
        }

        @media (max-width: 767px) {
            .team-img {
                height: 120px;
                width: 120px;
            }
            .container {
                max-width: 100%;
                padding: 10px;
            }

            .quill-content {
                font-size: 0.8rem; /* Adjust for readability */
                line-height: 1.4;
            }

            .about-section {
                padding: 10px;
                margin-bottom: 15px;
            }

            .animated-line {
                margin: 20px 0;
            }
        }

        /* Read More Toggle */
        .bio-text.collapsed {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- JavaScript for Read More/Read Less Toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toggleLinks = document.querySelectorAll('.toggle-bio');
            toggleLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    var id = this.getAttribute('id').replace('toggle-bio-', '');
                    var bioText = document.getElementById('bio-' + id);
                    if (bioText.classList.contains('collapsed')) {
                        bioText.classList.remove('collapsed');
                        this.textContent = 'Read Less';
                    } else {
                        bioText.classList.add('collapsed');
                        this.textContent = 'Read More';
                    }
                });
            });
        });
    </script>
@endsection
