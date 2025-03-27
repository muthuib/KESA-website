@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Past events and Activities</h2>
        <a href="{{ route('activities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Past event
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Video</th>
                <th>YouTube Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->title }}</td>
                    <td>{{ Str::limit($activity->description, 50) }}</td>
                    <td>
                        @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                            <a href="{{ asset($activity->media) }}" target="_blank">Download Video</a>
                        @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                            <img src="{{ asset($activity->media) }}" alt="Uploaded Image" style="max-width: 70px; max-height: 70px;">
                        @endif
                    </td>
                    <td>
                        @if($activity->youtube_link)
                            <a href="{{ $activity->youtube_link }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                        @else
                            <span class="text-muted">No link Added</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
