@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Publications</h1>

    <!-- Upload New Publication Button -->
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('publications.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload New Publication
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dar">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>File Size</th>
                    <th>Downloads</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publications as $publication)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $publication->title }}</td>
                        <td>{{ $publication->authors ?? 'N/A' }}</td>
                        <td>{{ number_format($publication->file_size / 1024, 2) }} KB</td>
                        <td>{{ $publication->downloads ?? 0 }}</td>
                        <td>{{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}</td>
                        <td>
                            <div class="card p-2">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('publications.show', $publication->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-sm btn-success">Download</a>
                                    <form action="{{ route('publications.destroy', $publication->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this publication?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No publications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
