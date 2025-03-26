@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px; position: relative;">
    <!-- Back Button at Top Right -->
    <a href="{{ route('executives.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>

    <h2 class="text-center mb-4">Executive Member Details</h2>
    <div class="card shadow-sm">
        @if($executive->image)
            <img src="{{ asset($executive->image) }}" class="card-img-top" alt="{{ $executive->name }}" style="height: 300px;width: 300px; object-fit: cover;">
        @endif
        <div class="card-body">
            <h4 class="card-title">{{ $executive->name }}</h4>
            <p class="card-text"><strong>{{ $executive->designation }}</strong></p>
            <!-- Bio Section with Read More/Read Less -->
            <!-- <div class="card-text bio-text collapsed" id="bioText">
                {!! $executive->bio !!}
            </div>
            @if(strlen(strip_tags($executive->bio)) > 100)
                <a href="javascript:void(0)" id="toggleBio">Read More</a>
            @endif
            @if($executive->cv_link)
                <a href="{{ $executive->cv_link }}" target="_blank" class="btn btn-primary mt-3">Download CV</a>
            @endif -->
        </div>
    </div>
</div>
@endsection

<!-- Inline CSS for Bio Collapse -->
<style>
    /* Initially show only 3 lines of the bio */
    .bio-text.collapsed {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Adjust number of lines to show as needed */
        -webkit-box-orient: vertical;
    }
</style>

<!-- Inline JavaScript to Toggle Bio -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var toggleBtn = document.getElementById('toggleBio');
    var bioText = document.getElementById('bioText');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (bioText.classList.contains('collapsed')) {
                bioText.classList.remove('collapsed');
                toggleBtn.textContent = 'Read Less';
            } else {
                bioText.classList.add('collapsed');
                toggleBtn.textContent = 'Read More';
            }
        });
    }
});
</script>
