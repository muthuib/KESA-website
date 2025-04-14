@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">All News</h2>

    <!-- Search Form -->
    <form action="{{ route('news.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search news..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    @if($news->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->date }}</td>
                    <td>
                        <a href="{{ route('news.show', $item) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('news.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('news.destroy', $item) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this news?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $news->appends(['search' => request('search')])->links() }}
        </div>
    @else
        <p class="text-muted">No news found.</p>
    @endif
</div>
@endsection
