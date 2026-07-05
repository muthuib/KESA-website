@extends('layouts.app')

@section('content')
<div class="container py-1">
       <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Testimonials</h1>
                <p class="text-muted mb-0">Central Hub for KESA Testimonials</p>
              </div>
            </div>
              <!-- Upload New Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('testimonials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Testimonial
                </a>
            </div>
          </div>
   <div class="table-responsive">
        <table class="table table-tiny table-sm">
          <thead class="thead">
            <tr>
                <!-- <th>#</th> -->
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
                    <!-- <td>{{ $loop->iteration }}</td> -->
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
                    <td class="p-1">
                        <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                            <a href="{{ route('testimonials.show', $testimonial->id) }}" class="btn btn-micro btn-info" title="View">
                                <i class="bi bi-eye"></i> 
                            </a>
                            <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-micro btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i> 
                            </a>
                            <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-micro btn-danger">
                                    <i class="bi bi-trash"></i> 
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
