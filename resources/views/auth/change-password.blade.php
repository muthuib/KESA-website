@extends('layouts.app')


<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="col-md-6 col-lg-5 bg-white p-5 shadow rounded-4 mt-5 mb-5">

        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" style="height: 80px;">
        </div>

        <h2 class="text-center mb-4 fw-bold text-primary">
            Change Password
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>

