@extends('layouts.app')

@section('content')
<div class="container mt-1">
     <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Success Stories</h1>
                <p class="text-muted mb-0">Central Hub for KESA Success Stories</p>
              </div>
            </div>
              <!-- Upload New Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('success_stories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Story
                </a>
            </div>
          </div>
    @if($stories->count())
  <div class="table-responsive">
        <table class="table table-tiny table-sm">
          <thead class="thead">
                    <tr>
                        <!-- <th style="width: 60px;">#</th> -->
                        <th style="width: 30%;">Title</th>
                        <th style="width: 20%;">Author</th>
                        <th style="width: 20%;">Published At</th>
                        <th style="min-width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $index => $story)
                        <tr>
                            <!-- <td>{{ ($stories->currentPage() - 1) * $stories->perPage() + $index + 1 }}</td> -->
                            <td class="text-start text-truncate" style="max-width: 250px;" title="{{ $story->title }}">
                                {{ $story->title }}
                            </td>
                            <td>{{ $story->author ?? '—' }}</td>
                            <td>{{ $story->published_at ? $story->published_at->format('d M Y') : '—' }}</td>
                            <td class="p-1">
                                <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                                    <a href="{{ route('success_stories.show', $story->slug) }}" 
                                       class="btn btn-micro btn-info" title="View">
                                        <i class="bi bi-eye"></i> 
                                    </a>
                                    <a href="{{ route('success_stories.edit', $story->id) }}" 
                                       class="btn btn-micro btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i> 
                                    </a>
                                    <form action="{{ route('success_stories.destroy', $story->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this story?')" 
                                          class="d-inline">
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
        <div class="mt-3 d-flex justify-content-center">
            {{ $stories->appends(request()->query())->links() }}
        </div>
    @else
        <div class="alert alert-info mt-4 text-center">No success stories found.</div>
    @endif
   </div>
 </div>
<!-- 
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
</style> -->
@endsection
