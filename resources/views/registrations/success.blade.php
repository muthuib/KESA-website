@extends('layouts.app')

@section('content')
    <h1>Registration Successful</h1>
    <p>Thank you for registering for the event <strong>{{ $event->name }}</strong>.</p>
    <p>Your registration details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $registration->name }}</li>
        <li><strong>Email:</strong> {{ $registration->email }}</li>
        <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    </ul>

    <p>Your QR Code for event check-in:</p>
    <img src="{{ asset($registration->qr_code_path) }}" alt="QR Code">
@endsection
