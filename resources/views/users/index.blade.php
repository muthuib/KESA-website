@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="margin-top: 40px;">Manage Users</h4>
        <a href="{{ route('users.index') }}" class="btn btn-light">
            <!-- <i class="fas fa-plus"></i> Add User -->
        </a>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="students-tab" data-bs-toggle="tab" href="#students" role="tab">
                Students ({{ $students->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="associates-tab" data-bs-toggle="tab" href="#associates" role="tab">
                Associates ({{ $associates->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="full-tab" data-bs-toggle="tab" href="#full" role="tab">
                Full Members ({{ $full->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="honorary-tab" data-bs-toggle="tab" href="#honorary" role="tab">
                Honorary Members ({{ $honorary->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="organization-tab" data-bs-toggle="tab" href="#organization" role="tab">
                Organizations ({{ $organization->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="unassigned-tab" data-bs-toggle="tab" href="#unassigned" role="tab">
                Unassigned ({{ $unassigned->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="admins-tab" data-bs-toggle="tab" href="#admins" role="tab">
                Admins ({{ $admins->count() }})
            </a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="students">
            <h4 style="color: maroon;">Total Number of Students: {{ $students->count() }}</h4>
            @include('partials.user_table', ['users' => $students])
        </div>
        <div class="tab-pane fade" id="associates">
            <h4 style="color: maroon;">Total Number of Associates: {{ $associates->count() }}</h4>
            @include('partials.user_table', ['users' => $associates])
        </div>
        <div class="tab-pane fade" id="full">
            <h4 style="color: maroon;">Total Number of Full Members: {{ $full->count() }}</h4>
            @include('partials.user_table', ['users' => $full])
        </div>
        <div class="tab-pane fade" id="honorary">
            <h4 style="color: maroon;">Total Number of Honorary Members: {{ $honorary->count() }}</h4>
            @include('partials.user_table', ['users' => $honorary])
        </div>
        <div class="tab-pane fade" id="organization">
            <h4 style="color: maroon;">Total Number of Organizations: {{ $organization->count() }}</h4>
            @include('partials.user_table', ['users' => $organization])
        </div>
        <div class="tab-pane fade" id="unassigned">
            <h4 style="color: maroon;">Total Number of Unassigned Users: {{ $unassigned->count() }}</h4>
            @include('partials.user_table', ['users' => $unassigned])
        </div>
        <div class="tab-pane fade" id="admins">
            <h4 style="color: maroon;">Total Number of Admins: {{ $admins->count() }}</h4>
            @include('partials.user_table', ['users' => $admins])
        </div>
    </div>
</div>

@endsection
