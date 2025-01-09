@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <!-- Card Container -->
            <div class="card shadow-lg" style="width: 1200px;">
                <!-- Card Header with Back Button -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="color: black;">Create New Event</h4>
                    <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm"><i class="fa fa-backward"></i> Back</a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Event Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Event Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter event name" required>
                            </div>
                            <!-- Location -->
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control" placeholder="Enter location" required>
                            </div>
                            <!-- Venue -->
                            <div class="col-md-6 mb-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" name="venue" id="venue" class="form-control" placeholder="Enter venue" required>
                            </div>
                            <!-- Date -->
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <!-- Start Time -->
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" required>
                            </div>
                            <!-- End Time -->
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" required>
                            </div>
                            <!-- Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Event Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter event description"></textarea>
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
