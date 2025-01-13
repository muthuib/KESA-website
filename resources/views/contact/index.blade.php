@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Contact Us</h1>
        <a href="{{ route('contact.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Contact
        </a>
    </div>

    @if($contacts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Organization Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->organization_name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>
                            <a href="{{ route('contact.display', $contact) }}" class="btn btn-info btn-sm">view</a>
                            <a href="{{ route('contact.edit', $contact) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('contact.destroy', $contact) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No contact information available. <a href="{{ route('contact.create') }}">Add one now.</a></p>
    @endif
</div>
@endsection
