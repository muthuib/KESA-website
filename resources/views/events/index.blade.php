@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Events</h1>
                <p class="text-muted mb-0">Central Hub for KESA Events</p>
              </div>
            </div>
              <!-- Upload New Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('events.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Event
                </a>
            </div>
          </div>
   <div class="table-responsive">
        <table class="table table-tiny table-sm">
        <thead class="thead">
            <tr>
                <th>Name</th>
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
                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i')  }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->end_time)->format('H:i')  }}</td>
                    <td>
                        @php
                            $eventDate = \Carbon\Carbon::parse($event->start_date);
                        @endphp
                        @if($eventDate->isToday() || $eventDate->isFuture())
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Expired</span>
                        @endif
                    </td>
                    <td class="p-1">
                                <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-micro btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-micro btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                       @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-micro btn-danger" onclick="return confirm('Are you sure you want to delete this Event?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
