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
                        <h5 class="fw-bold team-name text-center">{{ $executive->name }}</h5>
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
    </style>
@endsection
