@extends('layouts.app')

@section('content')
<div class="container py-1">
    <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Past Events & Activities</h1>
                <p class="text-muted mb-0">Central Hub for KESA Past Events</p>
              </div>
            </div>
              <!-- Upload  Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('activities.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Past Event
                </a>
            </div>
          </div>

    <div class="table-responsive">
        <table class="table table-tiny table-sm">
        <thead class="thead">
            <tr>
                <!-- <th>#</th> -->
                <th>Title</th>
                 <th>Date</th>
                <!-- <th>Activity Title</th> -->
                <!-- <th>Organizer Name</th>
                <th>Location</th>
                <th>Time</th> -->
                <th>Description</th>
                <th>Media</th>
                <th>YouTube Link</th>
                <th class="text-center">Views/Reads</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <!-- <td>{{ $loop->iteration }}</td> -->
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->date ? \Carbon\Carbon::parse($activity->date)->format('M d, Y') : '-' }}</td>
                    <!-- <td>{{ $activity->activity_title ?? '-' }}</td> -->
                    <!-- <td>{{ $activity->name ?? '-' }}</td>
                    <td>{{ $activity->location ?? '-' }}</td>
                    <td>
                        @if($activity->start_time && $activity->end_time)
                            {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }}
                        @else
                            -
                        @endif
                    </td> -->
                    <td>
                        <div style="max-height: 100px; overflow-y: auto;">
                            {!! Str::limit($activity->description, 100, '...') !!}
                        </div>
                    </td>
                    <td>
                        @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                            <a href="{{ asset($activity->media) }}" target="_blank">Download Video</a>
                        @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                            <img src="{{ asset($activity->media) }}" alt="Uploaded Image" style="max-width: 70px; max-height: 70px;">
                        @else
                            <span class="text-muted">No Media</span>
                        @endif
                    </td>
                    <td class="p-1">
                        @if($activity->youtube_link)
                            <a href="{{ $activity->youtube_link }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="fab fa-youtube" style = "font-size: 10px;"></i> 
                            </a>
                        @else
                            <span class="text-muted">No Link</span>
                        @endif
                    </td>
                    <td class="text-center">
                            <span class="badge bg-{{ $activity->views > 100 ? 'danger' : ($activity->views > 50 ? 'warning' : 'secondary') }}">
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($activity->views ?? 0) }}
                            </span>
                        </td>

                     <td class="p-1">
                                <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-micro btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-micro btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
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
