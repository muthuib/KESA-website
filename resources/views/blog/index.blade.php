@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">📚 Blog Posts</h5>
        <a href="{{ route('blog.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Add Blog
        </a>
    </div>

    <!-- Search -->
    <form action="{{ route('blog.index') }}" method="GET" class="mb-3">
        <div class="input-group input-group-sm">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search blog...">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Blog Table -->
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle text-sm">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Image</th>
                    <th scope="col">Snippet</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $index => $item)
                    <tr>
                        <td>{{ ($blogs->currentPage() - 1) * $blogs->perPage() + $index + 1 }}</td>
                        <td class="fw-semibold">{{ $item->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" alt="Image" class="img-thumbnail rounded" style="max-width: 80px;">
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ Str::limit(strip_tags($item->content), 80, '...') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('blog.show', $item->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('blog.edit', $item->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('blog.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this blog post?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No blog posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $blogs->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
