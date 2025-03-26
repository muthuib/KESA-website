@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Publications</h1>
    <!-- Upload New Publication Button, aligned to the right -->
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('publications.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload New Publication
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Download</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publications as $publication)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $publication->title }}</td>
                        <td>
                            <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-sm btn-success">
                                Download
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}</td>
                        <td>
                            <!-- View Button -->
                            <a href="{{ route('publications.show', $publication->id) }}" class="btn btn-sm btn-info">View</a>
                            <!-- Edit Button -->
                            <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <!-- Delete Button in a form to handle DELETE request -->
                            <form action="{{ route('publications.destroy', $publication->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this publication?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No publications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
