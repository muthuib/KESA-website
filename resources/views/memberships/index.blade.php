@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Memberships</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('memberships.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Member
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-">
                <tr>
                    <th>#</th> <!-- Dynamic numbering -->
                    <th>Name</th>
                    <th>Description</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memberships as $index => $membership)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Dynamic numbering -->
                        <td>{{ $membership->NAME }}</td>
                        
                        <td>{{ $membership->DESCRIPTION }}</td>
                        <td>
                            @if($membership->LOGO_PATH) <!-- Use uppercase column name -->
                                <img src="{{ asset($membership->LOGO_PATH) }}" 
                                    alt="{{ $membership->NAME }}" 
                                    style="width: 50px; height: 50px; object-fit: contain;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('memberships.edit', $membership->ID) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('memberships.destroy', $membership->ID) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No members found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
