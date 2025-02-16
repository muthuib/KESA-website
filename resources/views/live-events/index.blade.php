@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Live Events & Meetings</h2>
        <a href="{{ route('live-events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Live Event
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th> <!-- Row number -->
                <th>Title</th>
                <th>Platform</th>
                <th>Link</th>
                <th>Date & Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr> 
                    <!-- Display row number -->
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->platform }}</td>
                    <td><a href="{{ $event->link }}" target="_blank">Watch</a></td>
                    <td>{{ \Carbon\Carbon::parse($event->date_time)->format('M d, Y - h:i A') }}</td>
                    <td>
                        <a href="{{ route('live-events.edit', $event->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('live-events.destroy', $event->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($events->isEmpty())
        <p class="text-center text-muted">No live events available at the moment.</p>
    @endif
</div>
@endsection
