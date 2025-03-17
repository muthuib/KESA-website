@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Partners and Collaborators</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('collaborators.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Collaborator
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-">
                <tr>
                    <th>#</th> <!-- New numbering column -->
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Description</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collaborators as $index => $collaborator)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Dynamic numbering -->
                        <td>{{ $collaborator->NAME }}</td>
                        <td>
                        <img src="{{ asset($collaborator->LOGO_PATH) }}" 
                            alt="{{ $collaborator->NAME }}" 
                            style="width: 50px; height: 50px; object-fit: contain;">
                        </td>
                        <td>{{ $collaborator->DESCRIPTION }}</td>
                        <td>
                            @if($collaborator->WEBSITE)
                                <a href="{{ $collaborator->WEBSITE }}" target="_blank">{{ $collaborator->WEBSITE }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('collaborators.edit', $collaborator->ID) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('collaborators.destroy', $collaborator->ID) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this collaborator?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No collaborators found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
