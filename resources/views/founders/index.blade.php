@extends('layouts.app')
@php $isAjax = true; @endphp
@section('content')
<div class="container my-5" style="margin-top: 90px; position: relative;">
    <h2 class="text-center mb-4">Our Founders</h2>
    <div class="text-end mb-3">
            <!-- Back Button at Top Right -->
    <a href="{{ route('team-members.index') }}" class="btn btn-light" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward"></i> Back
    </a>
        <a href="{{ route('founders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Founder
        </a>
    </div>
    <div class="row">
        @forelse($founders as $founder)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($founder->image)
                <div class="text-center">
                    <img src="{{ asset($founder->image) }}" alt="{{ $founder->name }}" class="card-img-top" style="height: 220px; width: 220px; object-fit: contain; border-radius: 50%; margin: 0 auto;">
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $founder->name }}</h5>
                    <p class="card-text"><strong>{{ $founder->designation }}</strong></p>
                    <!-- Bio with Read More / Read Less -->
                    <p class="card-text bio-text collapsed" id="bio-{{ $founder->id }}">
                        {!! nl2br(e($founder->bio)) !!}
                    </p>
                    @if(strlen(strip_tags($founder->bio)) > 100)
                        <a href="javascript:void(0)" class="toggle-bio" id="toggle-bio-{{ $founder->id }}">Read More</a>
                    @endif
                </div>
                <div class="card-footer text-end">
                    @if($founder->cv_link)
                        <a href="{{ $founder->cv_link }}" target="_blank" class="btn btn-primary btn-sm">Download CV</a>
                    @endif
                    <a href="{{ route('founders.show', $founder->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('founders.edit', $founder->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('founders.destroy', $founder->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this founder?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No founders added yet.</p>
        </div>
        @endforelse
    </div>
</div>
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
