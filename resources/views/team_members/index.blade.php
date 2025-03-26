@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px; position: relative;">
    <!-- Back Button -->
    <a href="{{  route('about.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
    </a>
    <h2 class="text-center mb-4">Our People</h2>
    <div class="text-end mb-3">
        <a href="{{ route('team-members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Board Member
        </a>
        <a href="{{ route('executives.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Add New Executive Member
        </a>
        <a href="{{ route('founders.create') }}" class="btn btn-info">
            <i class="fas fa-plus-circle"></i> Add New Founder Member
        </a>
    </div>
    <div class="row">
        @forelse($teamMembers as $member)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($member->image)
                <div class="text-center">
                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="card-img-top" style="height: 220px; width: 220px; object-fit: contain; border-radius: 50%; margin: 0 auto;">
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $member->name }}</h5>
                    <p class="card-text"><strong>{{ $member->designation }}</strong></p>
                    <!-- Bio with Read More / Read Less -->
                    <p class="card-text bio-text collapsed" id="bio-{{ $member->id }}">
                        {!! nl2br(e($member->bio)) !!}
                    </p>
                    @if(strlen(strip_tags($member->bio)) > 100)
                        <a href="javascript:void(0)" class="toggle-bio" id="toggle-bio-{{ $member->id }}">Read More</a>
                    @endif
                </div>
                <div class="card-footer text-end">
                    @if($member->cv_link)
                        <a href="{{ $member->cv_link }}" target="_blank" class="btn btn-primary btn-sm">Download CV</a>
                    @endif
                    <a href="{{ route('team-members.show', $member->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('team-members.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('team-members.destroy', $member->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this team member?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No team members added yet.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- EXECUTIVE MEMBERS SECTION -->
<!-- load via ajax -->
<div id="executives-container"></div>

<!-- FOUNDERS SECTION (Loaded via AJAX) -->
<div id="founders-container"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('executives.index') }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("executives-container").innerHTML = html;
            })
            .catch(error => console.error('Error loading executives:', error));
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('founders.index') }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("founders-container").innerHTML = html;
            })
            .catch(error => console.error('Error loading founders:', error));
    });
</script>
@endsection

<!-- Inline CSS for Bio Collapse -->
<style>
    .bio-text.collapsed {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Display 3 lines initially */
        -webkit-box-orient: vertical;
    }
</style>

<!-- Inline JavaScript for Toggle Functionality -->
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
