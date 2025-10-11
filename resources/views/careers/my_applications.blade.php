@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3 text-dark">
        <i class="bi bi-briefcase me-2"></i> My Job Applications
    </h4>

    @if($applications->isEmpty())
        <div class="alert alert-info text-center rounded-3">
            <i class="bi bi-info-circle"></i> You haven’t applied for any jobs yet.
        </div>
    @else
        <table class="table table-hover align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Position</th>
                    <th>Applied On</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Cover Letter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $app->career->title ?? 'N/A' }}</td>
                        <td>{{ $app->created_at->format('d M Y, h:i A') }}</td>
                        
                        <td>
                            @if($app->resume)
                                <a href="{{ asset($app->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge
                                @if($app->status == 'Pending') bg-secondary
                                @elseif($app->status == 'Reviewed') bg-info
                                @elseif($app->status == 'Shortlisted') bg-success
                                @elseif($app->status == 'Rejected') bg-danger
                                @endif">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark" 
                                data-bs-toggle="modal" data-bs-target="#coverLetterModal{{ $app->id }}">
                                <i class="bi bi-envelope-open"></i> View
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="coverLetterModal{{ $app->id }}" tabindex="-1" 
                                aria-labelledby="coverLetterModalLabel{{ $app->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header" style="background: maroon; color: white; padding: 8px 16px;">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-envelope-paper me-2"></i> Cover Letter
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                            <p class="text-secondary" style="white-space: pre-wrap;">
                                                {{ $app->cover_letter }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
