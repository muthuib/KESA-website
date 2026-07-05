@extends('layouts.app')

@section('content')
<div class="container mt-0.5">
            <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">KESA</p>
                <h1 class="h3 mb-1">Publications</h1>
                <p class="text-muted mb-0">Central Hub for KESA Publications</p>
              </div>
            </div>
              <!-- Upload New Publication Button -->
            <div class="mb-3 d-flex justify-content-end">
                <a  style = "font-size:12px;" href="{{ route('publications.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Upload New Publication
                </a>
            </div>
          </div>
        <div class="table-responsive">
            <table class="table table-tiny table-sm">
                <thead class="thead">
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Title</th>
                        <th>Authors</th>
                        <th>File Size</th>
                        <th>Downloads</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publications as $publication)
                        <tr>
                            <!-- <td>{{ $loop->iteration }}</td> -->
                            <td>{{ $publication->title }}</td>
                            <td>{{ $publication->authors ?? 'N/A' }}</td>
                            <td>{{ number_format($publication->file_size / 1024, 2) }} KB</td>
                            <td>{{ $publication->downloads ?? 0 }}</td>
                            <td>{{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}</td>
                            <td class="p-1">
                                <div class="d-flex gap-1 justify-content-center align-items-center" style="flex-wrap: nowrap;">
                                    <a href="{{ route('publications.show', $publication->id) }}" class="btn btn-micro btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-micro btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-micro btn-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('publications.destroy', $publication->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-micro btn-danger" onclick="return confirm('Are you sure you want to delete this publication?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No publications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
