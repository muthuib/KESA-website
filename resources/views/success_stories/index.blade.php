@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h3 class="mb-0">All Success Stories</h3>
        <a href="{{ route('success_stories.create') }}" class="btn btn-success mt-2 mt-sm-0">
            <i class="bi bi-plus-circle me-1"></i> <span class="d-none d-sm-inline">Add Story</span>
        </a>
    </div>

    @if($stories->count())
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle table-striped text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 30%;">Title</th>
                        <th style="width: 20%;">Author</th>
                        <th style="width: 20%;">Published At</th>
                        <th style="min-width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $index => $story)
                        <tr>
                            <td>{{ ($stories->currentPage() - 1) * $stories->perPage() + $index + 1 }}</td>
                            <td class="text-start text-truncate" style="max-width: 250px;" title="{{ $story->title }}">
                                {{ $story->title }}
                            </td>
                            <td>{{ $story->author ?? '—' }}</td>
                            <td>{{ $story->published_at ? $story->published_at->format('d M Y') : '—' }}</td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <a href="{{ route('success_stories.show', $story->slug) }}" 
                                       class="btn btn-sm btn-info text-white d-flex align-items-center gap-1 action-btn">
                                        <i class="bi bi-eye"></i> 
                                        <span class="d-none d-md-inline">View</span>
                                    </a>
                                    <a href="{{ route('success_stories.edit', $story->id) }}" 
                                       class="btn btn-sm btn-warning d-flex align-items-center gap-1 action-btn">
                                        <i class="bi bi-pencil-square"></i> 
                                        <span class="d-none d-md-inline">Edit</span>
                                    </a>
                                    <form action="{{ route('success_stories.destroy', $story->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this story?')" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1 action-btn">
                                            <i class="bi bi-trash"></i> 
                                            <span class="d-none d-md-inline">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $stories->appends(request()->query())->links() }}
        </div>
    @else
        <div class="alert alert-info mt-4 text-center">No success stories found.</div>
    @endif
</div>

<style>
    /* Table General Styling */
    .table td, .table th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Action Buttons */
    .action-btn {
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-btn:hover {
        transform: scale(1.05);
    }

    /* Mobile Responsive: Icons Only */
    @media (max-width: 768px) {
        .action-btn {
            padding: 6px 8px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
        }

        .action-btn span {
            display: none !important;
        }
    }

    /* Table Container */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
    }
</style>
@endsection
