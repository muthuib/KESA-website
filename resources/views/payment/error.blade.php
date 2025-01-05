@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Payment Error
    </div>
    <div class="card-body">
        <p><strong>Error:</strong> {{ session('error') }}</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
    </div>
</div>
@endsection
