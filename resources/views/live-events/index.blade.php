@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Live Events & Meetings</h1>
                <p class="text-muted mb-0">Central Hub for KESA Live Events & Meetings</p>
              </div>
            </div>
              <!-- Upload New Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('live-events.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Live Event
                </a>
            </div>
          </div>

    <div class="table-responsive">
        <table class="table table-tiny table-sm">
        <thead class="thead">
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
                   <td class="p-1">
                      <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                        <a href="{{ route('live-events.edit', $event->id) }}" class="btn btn-micro btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('live-events.destroy', $event->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-micro btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($events->isEmpty())
        <p class="text-center text-muted">No live events available at the moment.</p>
    @endif
  </div>
</div>
@endsection
