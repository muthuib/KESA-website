@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Add New User</h1>
        <!-- Back button with a backward icon -->
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <!-- Error Message Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>There were some errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-light">
        @csrf
        <div class="mb-3">
            <label for="USERNAME" class="form-label fw-bold">Username</label>
            <input type="text" name="USERNAME" id="USERNAME" class="form-control" value="{{ old('USERNAME') }}" required placeholder="Enter username">
        </div>

        <div class="mb-3">
            <label for="EMAIL" class="form-label fw-bold">Email</label>
            <input type="email" name="EMAIL" id="EMAIL" class="form-control" value="{{ old('EMAIL') }}" required placeholder="Enter email">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="PASSWORD_HASH" class="form-label fw-bold">Password</label>
                <input type="password" name="PASSWORD_HASH" id="PASSWORD_HASH" class="form-control" required placeholder="Enter password">
            </div>
            <div class="col-md-6 mb-3">
                <label for="PASSWORD_HASH_confirmation" class="form-label fw-bold">Confirm Password</label>
                <input type="password" name="PASSWORD_HASH_confirmation" id="PASSWORD_HASH_confirmation" class="form-control" required placeholder="Confirm password">
            </div>
        </div>

        <div class="mb-3">
            <label for="ROLE" class="form-label fw-bold">Role</label>
            <select name="ROLE" id="ROLE" class="form-select" required>
                <option value="" disabled selected>Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('ROLE') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create User
            </button>
        </div>
    </form>
</div>
@endsection
