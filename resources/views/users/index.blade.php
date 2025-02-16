@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Manage Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="admins-tab" data-bs-toggle="tab" href="#admins" role="tab">
                Admins ({{ $admins->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="members-tab" data-bs-toggle="tab" href="#members" role="tab">
                Members ({{ $members->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="partners-tab" data-bs-toggle="tab" href="#partners" role="tab">
                Partners ({{ $partners->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="unassigned-tab" data-bs-toggle="tab" href="#unassigned" role="tab">
                Unassigned ({{ $unassigned->count() }})
            </a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="admins">
            <h4 style="color: maroon;">Total Number of Admins is: {{ $admins->count() }}</h4>
            @include('partials.user_table', ['users' => $admins])
        </div>
        <div class="tab-pane fade" id="members">
            <h4 style="color: maroon;">Total Number of Members is: {{ $members->count() }}</h4>
            @include('partials.user_table', ['users' => $members])
        </div>
        <div class="tab-pane fade" id="partners">
            <h4 style="color: maroon;">Total Number of Partners is: {{ $partners->count() }}</h4>
            @include('partials.user_table', ['users' => $partners])
        </div>
        <div class="tab-pane fade" id="unassigned">
            <h4 style="color: maroon;">Total Number of Unassigned users is: {{ $unassigned->count() }}</h4>
            @include('partials.user_table', ['users' => $unassigned])
        </div>
    </div>
</div>

@endsection
