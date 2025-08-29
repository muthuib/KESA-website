@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- User Info Panel -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInLeft">
                <div class="d-flex justify-content-center mt-3">
                    <img src="{{ asset($user->PASSPORT_PHOTO) }}" class="rounded-circle shadow" alt="Profile Picture" style="width: 130px; height: 130px; object-fit: cover;">
                </div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">{{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</h5>
                    <p class="text-muted mb-1" style="font-size: 14px;">
                        Membership Number: 
                        <span class="fw-bold text-primary">
                           @if(!$user->role) 
                                Pending Approval
                            @else
                                {{ $user->MEMBERSHIP_NUMBER }}
                            @endif

                        </span>
                    </p>
                    <a href="{{ route('profile.edit', $user->ID) }}" class="btn btn-outline-primary btn-sm mt-2">Edit Profile</a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="list-group shadow-sm animate__animated animate__fadeInLeft">
                <a href="{{ route('user-dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="{{ route('user-dashboard') }}" class="list-group-item list-group-item-action">Notifications</a>
                <a href="{{ route('user-dashboard') }}" class="list-group-item list-group-item-action">Activities</a>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="col-md-9">
            <!-- Hero Welcome Message -->
            <div class="bg-light p-4 rounded shadow-sm mb-4 animate__animated animate__fadeInUp">
               @if($user->role)
                    <h2 class="fw-bold mb-1">
                        Welcome, {{ $user->FIRST_NAME }} {{ $user->LAST_NAME }} 
                            <span class="text-success">({{ $user->role->name }})</span>
                        </h2>
                    @else
                        <h2 class="fw-bold mb-1">
                            Welcome, {{ $user->FIRST_NAME }} {{ $user->LAST_NAME }} 
                            <span class="text-warning">(Pending Approval)</span>
                        </h2>
                    @endif

                <p class="text-muted">Your personalized space for updates, tools, and resources within KESA.</p>
            </div>

            <!-- Notifications Section -->
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="card-title mb-3">🔔 Recent Notifications</h4>
                    @if($notifications->count())
                        <ul class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $notification->data['message'] }}
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No notifications at the moment.</p>
                    @endif
                    <a href="{{ route('user-dashboard') }}" class="btn btn-sm btn-link mt-2">View All Notifications from your email</a>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="card-title mb-3">📋 Recent Activities</h4>
                    <ul class="list-group list-group-flush">
                        <!-- You can dynamically add activities here -->
                        <li class="list-group-item text-muted">No recent activities to display.</li>
                    </ul>
                    <a href="{{ route('user-dashboard') }}" class="btn btn-sm btn-link mt-2">View All Activities</a>
                </div>
            </div>

            <!-- Quick Access Section -->
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="card-title mb-3">🚀 Quick Access</h4>
                    <div class="list-group">
                        <a href="{{ route('user-dashboard') }}" class="list-group-item list-group-item-action">Events</a>
                        <a href="{{ route('resources.index') }}" class="list-group-item list-group-item-action">Resources</a>
                        <a href="{{ route('user-dashboard') }}" class="list-group-item list-group-item-action">Discussions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
