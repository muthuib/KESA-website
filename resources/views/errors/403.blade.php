@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="display-4">403</h1>
    <p class="lead">You do not have permission to access this page.</p>
    <a href="{{ url('/user-dashboard') }}" class="btn btn-primary">Go to Homepage</a>
</div>
@endsection

<!-- Update Handler for Custom Errors:
In app/Exceptions/Handler.php, customize the render() method: -->