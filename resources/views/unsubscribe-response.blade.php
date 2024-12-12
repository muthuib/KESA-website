@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <!-- Message Section -->
    <div class="text-center mb-5 p-5" style="background-color: cyan; color: black; border-radius: 8px; width: 850px; margin-left: 220px;">
        <h1 class="display-4 fw-bold" style="font-size: 20px; margin: 0;">
            Unsubscribe Confirmation
        </h1>
        <p class="lead fw-bold" style="font-size: 15px; margin: 0;">
            <i>Your request has been processed successfully.</i>
        </p>
    </div>

    <!-- Success or Error Message -->
    @if(session('success'))
        <div class="alert alert-success text-center">
            <h4 class="alert-heading">Success!</h4>
            <p>{{ session('success') }}</p>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">
            <h4 class="alert-heading">Error!</h4>
            <p>{{ session('error') }}</p>
        </div>
    @endif

</div>

@endsection
