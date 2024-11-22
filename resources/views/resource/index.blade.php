@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Resources</h1>
    <a href="{{ route('create') }}" class="btn btn-primary mb-3">Create New Resource</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->TITLE }}</td>
                <td>{{ $resource->DESCRIPTION }}</td>
                <td>{{ $resource->PRICE > 0 ? '$' . $resource->PRICE : 'Free' }}</td>
                <td>
                    <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection