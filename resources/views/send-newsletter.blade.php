@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Send Newsletter</h2>
    <!-- Back button with a backward icon -->
    <div class="mb-3 text-end">
        <a href="{{ route('newsletters.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    <form method="POST" action="{{ route('send.newsletter') }}">
        @csrf
        <!-- Subject input -->
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <!-- Message input -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            <small class="text-muted">An unsubscribe button will be automatically included at the bottom of the email.</small>
        </div>
        <!-- Send button -->
        <button type="submit" class="btn btn-primary">Send Newsletter</button>
    </form>

    <!-- Display error messages -->
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
