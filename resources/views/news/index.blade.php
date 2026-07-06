@extends('layouts.app')

@section('content')
<div class="container mt-1">
   <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">News</h1>
                <p class="text-muted mb-0">Central Hub for KESA News</p>
              </div>
            </div>
              <!-- Upload New Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add News
                </a>
            </div>
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
        <table class="table table-tiny table-sm">
          <thead class="thead">
                <tr>
                    <!-- <th>#</th> -->
                    <th>Title</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Content Snippet</th>
                    <th class="text-center">Views/Reads</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $item)
                    <tr>
                        <!-- <td>{{ ($news->currentPage() - 1) * $news->perPage() + $index + 1 }}</td> -->
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->date }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ Str::limit(strip_tags($item->content), 100, '...') }}</td>
                         <td class="text-center">
                            <span class="badge bg-{{ $item->views > 100 ? 'danger' : ($item->views > 50 ? 'warning' : 'secondary') }}">
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($item->views ?? 0) }}
                            </span>
                        </td>
                        <td class="p-1">
                                <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-micro btn-info" title="View">
                                        <i class="fas fa-eye me-2"></i> 
                                    </a>
                                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-micro btn-warning" title="Edit">
                                        <i class="fas fa-edit me-2"></i> 
                                    </a>
                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this news?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-micro btn-danger">
                                            <i class="fas fa-trash-alt me-2"></i> 
                                        </button>
                                    </form>
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
    {{ $news->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
   </div>
</div>
@endsection
