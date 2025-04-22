@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="col-md-6 col-lg-5 bg-white p-5 shadow rounded-4 mt-5 mb-5">
        
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" style="height: 80px;">
        </div>

        <h2 class="text-center mb-4 fw-bold text-primary">
            Forgot Password
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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row g-3">
                <!-- Email input: full width on small/medium, 8 cols on large -->
                <div class="col-12 col-lg-8">
                    <label class="form-label fw-semibold">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <!-- Send button: full width on small/medium, 4 cols on large -->
                <div class="col-12 col-lg-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Send
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
