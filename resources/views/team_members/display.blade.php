@extends('layouts.app')

@section('content')
    <!-- Meet the Team Section -->
    <div class="container my-5">
    <h3 class="text-center mb-4 section-title" style="margin-top: 115px;">Organizational Structure</h3>
    <p class="section-subtitle" style="color:black;"><i>Meet Our Board Members, Executives, and Founders</i></p>
<!-- BOARD MEMBERS -->
    <p class="section-subtitle" style="text-align: center; font-size: 30px;">Board of Management </p>
    @if($teamMembers->isNotEmpty())
        <div class="team-container">  <!-- Use the CSS Grid Wrapper -->
            @foreach($teamMembers as $member)
                <div class="team-card shadow border-secondary">
                    @if($member->image)
                        <div class="text-center">
                            <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="team-img">
                        </div>
                    @endif
                    <h5 class="fw-bold team-name text-center">{{ $member->name }}</h5>
                    <p class="text-primary team-role text-center">{{ $member->designation }}</p>
                    
                    <!-- Bio Section -->
                    <div class="bio-text collapsed text-muted" id="bio-{{ $member->id }}">
                        {!! nl2br(e($member->bio)) !!}
                    </div>
                    @if(strlen(strip_tags($member->bio)) > 100)
                        <a href="javascript:void(0)" class="toggle-bio text-decoration-none fw-bold" 
                           id="toggle-bio-{{ $member->id }}" 
                           onclick="toggleBio({{ $member->id }})">
                           Read More
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">No Board members added yet.</p>
    @endif
</div>
<!-- EXECUTIVE MEMBERS SECTION -->
<!-- load via ajax -->
<div id="executives-container"></div>

<!-- FOUNDERS SECTION (Loaded via AJAX) -->
<div id="founders-container"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('executives.display') }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("executives-container").innerHTML = html;
            })
            .catch(error => console.error('Error loading executives:', error));
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('founders.display') }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("founders-container").innerHTML = html;
            })
            .catch(error => console.error('Error loading founders:', error));
    });
</script>


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
