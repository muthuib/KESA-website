@extends('layouts.app')

@section('content')
    <h1>Register for {{ $event->name }}</h1>
    <form action="{{ route('registrations.store', $event) }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>

        <button type="submit">Register</button>
    </form>
@endsection
