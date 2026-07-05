@extends('layouts.app')
@php $isAjax = true; @endphp
@section('content')
    <!-- Meet the Executives Section -->
    <div class="container my-5">
        <p class="section-subtitle" style="font-size: 30px;">Executive Council </p>

        @if($executives->isNotEmpty())
            <div class="team-container">  <!-- Use the CSS Grid Wrapper -->
                @foreach($executives as $executive)
                    <div class="team-card shadow border-secondary">
                        @if($executive->image)
                            <div class="text-center">
                                <img src="{{ asset($executive->image) }}" alt="{{ $executive->name }}" class="team-img">
                            </div>
                        @endif
                        <h5 class="fw-bold team-name text-center">
                        {{ $executive->name }}
                        @if($executive->cv_link)
                            <a href="{{ $executive->cv_link }}" target="_blank" class="linkedin-link" title="LinkedIn Profile">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0A66C2">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                    </h5>
                        <p class="text-primary team-role text-center">{{ $executive->designation }}</p>

                        <!-- Bio Section -->
                        <div class="bio-text collapsed text-muted" id="bio-{{ $executive->id }}">
                            {!! nl2br(e($executive->bio)) !!}
                        </div>
                        @if(strlen(strip_tags($executive->bio)) > 100)
                            <a href="javascript:void(0)" class="toggle-bio text-decoration-none fw-bold" 
                               id="toggle-bio-{{ $executive->id }}" 
                               onclick="toggleBio({{ $executive->id }})">
                               Read More
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">No executives added yet.</p>
        @endif
    </div>

    <!-- JavaScript for Read More/Read Less -->
    <script>
        function toggleBio(id) {
            let bio = document.getElementById('bio-' + id);
            let toggleBtn = document.getElementById('toggle-bio-' + id);

            if (bio.style.maxHeight === '60px') {
                bio.style.maxHeight = 'none';
                toggleBtn.textContent = 'Read Less';
            } else {
                bio.style.maxHeight = '60px';
                toggleBtn.textContent = 'Read More';
            }
        }
    </script>

    <!-- Responsive Styles -->
    <style>
        .section-title {
            font-weight: bold;
            margin-top: 90px;
            font-size: 2rem;
        }
        .section-subtitle {
            font-size: 1.2rem;
            color: rgb(132, 52, 52);
            font-weight: bold;
            text-align: center;
        }
        .team-img {
            width: 170px;
            height: 170px;
            object-fit: contain;
            border-radius: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .team-name {
            font-size: 1.5rem;
        }
        .team-role {
            font-weight: 600;
            font-size: 1.1rem;
        }
        .bio-text {
            max-height: 60px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .toggle-bio {
            color: #007bff;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }
            .section-subtitle {
                font-size: 1rem;
            }
            .team-img {
                width: 120px;
                height: 120px;
            }
            .team-name {
                font-size: 1.2rem;
            }
            .team-role {
                font-size: 1rem;
            }
        }
        .team-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns per row by default (large screens) */
            gap: 15px; /* Space between cards */
        }

        /* Medium and small screens: 2 columns per row */
        @media (max-width: 991px) {  
            .team-container {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        /* Extra small screens: 1 column per row */
        @media (max-width: 576px) {  
            .team-container {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        .linkedin-link {
                display: inline-block;
                margin-left: 8px;
                text-decoration: none;
                vertical-align: middle;
                transition: transform 0.2s ease;
            }

            .linkedin-link svg {
                width: 15px;
                height: 15px;
                display: block;
            }

            .linkedin-link:hover {
                transform: scale(1.15);
            }

            /* If using Font Awesome or Bootstrap Icons */
            .linkedin-link i {
                vertical-align: middle;
                transition: transform 0.2s ease;
            }

            .linkedin-link:hover i {
                transform: scale(1.15);
            }
    </style>
@endsection
