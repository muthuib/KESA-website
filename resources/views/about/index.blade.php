@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="margin-top: 70px;">{{ $aboutUs->TITLE ?? 'About Us' }}</h1>
    @auth
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('about.edit') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Edit About Us
        </a>
    </div>
    @endauth
    <p class="mt-4">
        {{ $aboutUs->CONTENT ?? 'We are committed to delivering value-driven solutions to our clients and partners.' }}
    </p>
</div>
@endsection
