@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Edit User</h1>
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

    <form action="{{ route('users.update', $user->ID) }}" method="POST" class="p-4 border rounded shadow-sm bg-light">
        @csrf
        @method('PUT')

        <!-- row -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="USERNAME" class="form-label fw-bold">Username</label>
            <input type="text" name="USERNAME" id="USERNAME" class="form-control" value="{{ $user->USERNAME }}" required placeholder="Enter username">
        </div>

        <div class="col-md-6 mb-3">
            <label for="EMAIL" class="form-label fw-bold">Email</label>
            <input type="email" name="EMAIL" id="EMAIL" class="form-control" value="{{ $user->EMAIL }}" required placeholder="Enter email">
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="FIRST_NAME" class="form-label fw-bold">First Name</label>
            <input type="text" name="FIRST_NAME" id="FIRST_NAME" class="form-control" value="{{ $user->FIRST_NAME }}" required placeholder="Enter First Name">
        </div>

        <div class="col-md-6 mb-3">
            <label for="LAST_NAME" class="form-label fw-bold">Last Name</label>
            <input type="text" name="LAST_NAME" id="LAST_NAME" class="form-control" value="{{ $user->LAST_NAME }}" required placeholder="Enter Last Name">
        </div>
    </div>
     <!-- row -->
     <div class="row">
        <div class="col-md-6 mb-3">
            <label for="COURSE" class="form-label fw-bold">Course</label>
            <input type="text" name="COURSE" id="COURSE" class="form-control" value="{{ $user->COURSE }}" required placeholder="Enter Course">
        </div>

        <div class="col-md-6 mb-3">
            <label for="UNIVERSITY" class="form-label fw-bold">University</label>
            <input type="text" name="UNIVERSITY" id="UNIVERSITY" class="form-control" value="{{ $user->UNIVERSITY }}" required placeholder="Enter University">
        </div>
    </div>
       <!-- row -->
    <div class="row">
            <div class="col-md-6 mb-3">
                <label for="CATEGORY" class="form-label fw-bold">Category</label>
                <select id="CATEGORY" name="CATEGORY" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                            {{ old('CATEGORY', $user->CATEGORY) == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('CATEGORY')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>


       <div class="col-md-6 mb-3">
            <label for="role_id" class="form-label fw-bold">Role</label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="" disabled>Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="PASSWORD_HASH" class="form-label fw-bold">New Password</label>
            <input type="password" name="PASSWORD_HASH" id="PASSWORD_HASH" class="form-control" placeholder="Leave blank to keep current password">
        </div>
    </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update User
            </button>
        </div>
    </form>
</div>
@endsection
