@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Member Dashboard</h1>
    <!-- Add content specific to members here -->
    <p>Welcome, {{ auth()->user()->FIRST_NAME }}</p>
    <!-- Add relevant member-specific information -->
</div>
@endsection
