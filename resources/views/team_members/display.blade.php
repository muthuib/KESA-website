@extends('layouts.app')

@section('content')
    <!-- Meet the Team Section -->
    <div class="container my-5">
        <h3 class="text-center mb-4 section-title">Organizational Structure</h3>
        <p class="section-subtitle">Meet Our Board Members, Executives, and Founders</p>

        @if($teamMembers->isNotEmpty())
            <div class="row g-4">
                @foreach($teamMembers as $member)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card h-100 shadow-lg border-0 p-3">
                            @if($member->image)
                                <div class="text-center mt-3">
                                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="team-img">
                                </div>
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold team-name">{{ $member->name }}</h5>
                                <p class="card-text text-primary team-role">{{ $member->designation }}</p>
                                
                                <!-- Bio Section with Read More/Read Less -->
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
                            <div class="card-footer text-center bg-white border-0 pb-3">
                                @if($member->cv_link)
                                    <a href="{{ $member->cv_link }}" target="_blank" 
                                       class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                       Download CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-4">
                <p class="text-muted">No team members added yet.</p>
            </div>
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
            object-fit: cover;
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
    </style>
@endsection
