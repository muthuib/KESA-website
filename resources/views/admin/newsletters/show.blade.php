@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Newsletter Details</h1>
    <div>
    <div class="mb-3 text-end">
        <a href="{{ route('newsletters.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
        <strong>Subject:</strong> {{ $newsletter->SUBJECT }}
    </div>
    <div>
        <strong>Message:</strong> {{ $newsletter->MESSAGE }}
    </div>
    <div>
        <strong>Created At:</strong> {{ $newsletter->CREATED_AT }}
    </div>
</div>
@endsection
