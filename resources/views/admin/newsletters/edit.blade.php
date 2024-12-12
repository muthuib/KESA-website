@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Newsletter</h1>
    <form action="{{ route('newsletters.update', $newsletter->ID) }}" method="POST">
    <div class="mb-3 text-end">
        <a href="{{ route('newsletters.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $newsletter->SUBJECT) }}">
            @error('subject')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control">{{ old('message', $newsletter->MESSAGE) }}</textarea>
            @error('message')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
