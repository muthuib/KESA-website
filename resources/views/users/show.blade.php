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
                <i class="fas fa-envelope text-secondary"></i> Email: <span class="text-dark">{{ $user->EMAIL }}</span>
            </h5>
            <p class="card-text">
                <strong>Roles:</strong>
                @if($user->roles->isEmpty())
                    <span class="text-danger">No roles assigned</span>
                @else
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                @endif
            </p>
        </div>
    </div>
</div>
@endsection