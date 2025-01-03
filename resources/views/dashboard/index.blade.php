@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- User Info Panel -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="{{ asset('path/to/profile-picture.jpg') }}" class="card-img-top rounded-circle" alt="Profile Picture">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</h5>
                        <p class="card-text">Welcome back! Here’s your personalized dashboard.</p>
                        <a href="{{ route('user-dashboard') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('user-dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('user-dashboard') }}">Notifications</a>
                    <a class="nav-link" href="{{ route('user-dashboard') }}">Activities</a>
                </nav>
            </div>

            <!-- Main Content Section -->
            <div class="col-md-9">
                <!-- Hero Section: Welcome Message & Statistics -->
                <div class="mb-4">
                    <h1>Welcome, {{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</h1>
                    <p>Your go-to space for insights, notifications, and quick access to KESA resources.</p>
                </div>

                <!-- Notifications Section -->
                <div class="mb-4">
                    <h3>Recent Notifications</h3>
                    <ul class="list-group">
                        @foreach($notifications as $notification)
                            <li class="list-group-item">
                                {{ $notification->data['message'] }}
                                <span class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('user-dashboard') }}" class="btn btn-link">View All Notifications</a>
                </div>

                <!-- Recent Activities Section -->
                <div class="mb-4">
                    <h3>Recent Activities</h3>
                    <ul class="list-group">
                        @foreach($recentActivities as $activity)
                            <li class="list-group-item">
                                {{ $activity->description }}
                                <span class="text-muted float-end">{{ $activity->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('user-dashboard') }}" class="btn btn-link">View All Activities</a>
                </div>

                <!-- Quick Links Section -->
                <div class="mb-4">
                    <h3>Quick Access</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{ route('user-dashboard') }}" class="text-decoration-none">Events</a></li>
                        <li class="list-group-item"><a href="{{ route('resources.index') }}" class="text-decoration-none">Resources</a></li>
                        <li class="list-group-item"><a href="{{ route('user-dashboard') }}" class="text-decoration-none">Discussions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
