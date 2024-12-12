<!-- resources/views/thankyou.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container mt-5" style="margin-left: 0px; margin-right: 0px; margin-top: 150px;">
    <!-- Hero Section with background color -->
<!-- Success or Error Message -->
@if(session('success'))
        <div class="alert alert-success text-center" style="margin-top: 150px;">
            <h4 class="alert-heading">Success!</h4>
            <p>{{ session('success') }}</p>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">
            <h4 class="alert-heading">Error!</h4>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="row mt-5 text-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fas fa-newspaper fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">News & Updates</h5>
                    <p class="card-text">Stay informed with the latest happenings in our community.</p>
                    <a href="{{ route('app') }}" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Events & Debates</h5>
                    <p class="card-text">Join upcoming events and engage in enriching discussions.</p>
                    <a href="{{ route('app') }}" class="btn btn-success">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fas fa-book fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Resources</h5>
                    <p class="card-text">Access valuable resources to enhance your knowledge and skills.</p>
                    <a href="{{ route('resources.show') }}" class="btn btn-warning">Get Resources</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = "{{ session('success') }}";
        if (successMessage) {
            var myModal = new bootstrap.Modal(document.getElementById('thankYouModal'), {
                keyboard: false
            });
            myModal.show();
        }
    });
</script>
@endsection
