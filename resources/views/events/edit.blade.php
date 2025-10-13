@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <!-- Card Container -->
            <div class="card shadow-lg" style="width: 1100px;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card Header with Back Button -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="color: brown;">Edit Event</h4>
                    <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">
                        <i class="fa fa-backward"></i> Back
                    </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Event name and Location in the same row -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Event Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $event->name) }}" placeholder="Enter event name" required>
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" placeholder="Enter location" required>
                            </div> -->
                        </div>

                        <!-- Venue and Date  -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" name="venue" id="venue" class="form-control" value="{{ old('venue', $event->venue) }}" placeholder="Enter venue" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $event->start_date) }}" required>
                            </div>
                        </div>

                        <!-- Start time and End time -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}" required>
                            </div>
                        </div>

                    <div class="row">
                        <!-- Event Link (New field) -->
                        <div class="col-md-6 mb-3">
                            <label for="link" class="form-label">Event registration Link</label>
                            <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $event->link) }}" placeholder="Enter event page link">
                        </div>
                        <!-- Event Image -->
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Event Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if($event->image)
                                <div class="mt-3">
                                    <strong>Current Image:</strong><br>
                                    <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="img-fluid" style="max-width: 300px; width: 50px;">
                                </div>
                            @endif
                        </div>
                    </div>

                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter event description">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
