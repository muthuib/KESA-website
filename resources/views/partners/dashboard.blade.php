@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Partner Dashboard</h1>
    <!-- Add content specific to partners here -->
    <p>Welcome, {{ auth()->user()->FIRST_NAME }}</p>
    <!-- Add relevant partner-specific information -->
</div>
@endsection
