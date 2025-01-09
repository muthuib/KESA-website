@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>All Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Event
        </a>
    </div>

    <table class="table mt-3 table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th> <!-- New column for status -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i')  }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->end_time)->format('H:i')  }}</td>
                    <td>
                        @if(\Carbon\Carbon::parse($event->start_date)->isFuture())
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Expired</span>
                        @endif
                    </td>
                    <td>
                        <!-- View Button -->
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>

                        <!-- Edit Button -->
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete Button -->
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
