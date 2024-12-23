@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center"style = "margin-top: 80px;">{{ $aboutUs->title ?? 'About Us' }}</h1>
    @auth
    <a href="{{ route('about.edit') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add About Us
        </a>
        @endauth
    <p class="mt-4">
        {{ $aboutUs->CONTENT ?? 'We are committed to delivering value-driven solutions to our clients and partners.' }}
    </p>
</div>
@endsection
