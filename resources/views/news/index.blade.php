@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">News</h2>

    <!-- Add News button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add News
        </a>
    </div>

    <!-- Search bar -->
    <form action="{{ route('news.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search news...">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- News table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dar">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Content Snippet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $item)
                    <tr>
                        <td>{{ ($news->currentPage() - 1) * $news->perPage() + $index + 1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->date }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ Str::limit(strip_tags($item->content), 100, '...') }}</td>
                        <td>
                            <div class="card p-2">
                                <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-info btn-sm d-flex align-items-center">
                                        <i class="fas fa-eye me-2"></i> View
                                    </a>
                                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this news?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm d-flex align-items-center">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No news found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $news->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
