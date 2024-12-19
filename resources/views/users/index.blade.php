@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Manage Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Sequential numbering -->
                    <td>{{ $user->USERNAME }}</td>
                    <td>{{ $user->EMAIL }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary" style="font-size: medium;">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('users.assignRolesForm', $user->ID) }}" class="btn btn-success btn-sm">Assign Roles</a>
                        <a href="{{ route('users.show', $user->ID) }}" class="btn btn-info btn-sm">View</a> <!-- View Button -->
                        <a href="{{ route('users.edit', $user->ID) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->ID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
