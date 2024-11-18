<!-- resources/views/auth/verify.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('resent'))
    <div class="alert alert-success" role="alert">
        A fresh verification link has been sent to your email address.
    </div>
    @endif

    <div class="alert alert-info" role="alert">
        Please verify your email address to continue. A verification link has been sent to your email.
    </div>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
</div>
@endsection