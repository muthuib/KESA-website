@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">User Details</h1>
        <!-- Back button with a backward icon -->
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">
                <i class="fas fa-user-circle text-warning"></i> Username: <span class="text-dark">{{ $user->USERNAME }}</span>
            </h4>
            <h5 class="card-subtitle mb-3 text-muted">
                <i class="fas fa-user text-info"></i> Name: <span class="text-dark">{{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</span>
            </h5>
            <h5 class="card-subtitle mb-3 text-muted">
                <i class="fas fa-envelope text-secondary"></i> Email: <span class="text-dark">{{ $user->EMAIL }}</span>
            </h5>
            <h5 class="card-subtitle mb-3 text-muted">
                <i class="fas fa-book text-secondary"></i> Course: <span class="text-dark">{{ $user->COURSE }}</span>
            </h5>
            <h5 class="card-subtitle mb-3 text-muted">
                <i class="fas fa-user-graduate text-dark"></i> University: <span class="text-dark">{{ $user->UNIVERSITY }}</span>
            </h5>
            <h5 class="card-subtitle mb-3 text-muted">
                <i class="fas fa-book text-dark"></i> Category: <span class="text-dark">{{ $user->CATEGORY }}</span>
            </h5>
            <p class="card-text">
               <strong>Role:</strong>
                @if($user->role)
                    <span class="badge bg-primary">{{ $user->role->name }}</span>
                @else
                    <span class="text-danger">No role assigned</span>
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
