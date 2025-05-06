@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Testimonials</h2>
        <a href="{{ route('testimonials.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Testimonial
        </a>
    </div>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th style="width: 150px;">Name</th>
                <th>Position</th>
                <th style="width: 150px;">Date</th>
                <th>Content</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $testimonial)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $testimonial->name }}</td>
                    <td>{{ $testimonial->position }}</td>
                    <td>{{ $testimonial->date ? $testimonial->date->format('D, M j, Y') : 'N/A' }}</td>
                    <td>{{ Str::limit($testimonial->content, 100) }}</td>
                    <td>
                        @if($testimonial->photo)
                            <img src="{{ asset('testimonials/' . $testimonial->photo) }}" width="50" height="50" class="rounded">
                        @else
                            No photo
                        @endif
                    </td>
                    <td>
                        <div class="card p-2 d-flex flex-row gap-1 justify-content-center align-items-center">
                            <a href="{{ route('testimonials.show', $testimonial->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
