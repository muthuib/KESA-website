@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Past Events and Activities</h2>
        <a href="{{ route('activities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Past Event
        </a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Activity Title</th>
                <!-- <th>Organizer Name</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th> -->
                <th>Description</th>
                <th>Media</th>
                <th>YouTube Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->activity_title ?? '-' }}</td>
                    <!-- <td>{{ $activity->name ?? '-' }}</td>
                    <td>{{ $activity->location ?? '-' }}</td>
                    <td>{{ $activity->date ? \Carbon\Carbon::parse($activity->date)->format('M d, Y') : '-' }}</td>
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
                    <td>
                        @if($activity->youtube_link)
                            <a href="{{ $activity->youtube_link }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                        @else
                            <span class="text-muted">No Link</span>
                        @endif
                    </td>
                    <td>
                        <div class="card p-2">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-info btn-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-eye"></i>
                                        <span class="ms-2">View</span>
                                    </div>
                                </a>
                                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning btn-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-edit"></i>
                                        <span class="ms-2">Edit</span>
                                    </div>
                                </a>
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this activity?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                            <span class="ms-2">Delete</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
