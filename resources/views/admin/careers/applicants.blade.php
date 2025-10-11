@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Applicants for {{ $career->title }}</h4>

    @php
        $applicantCount = \App\Models\CareerApplication::where('career_id', $career->id)->count();
    @endphp

   <p style="color: maroon; font-weight: bold;"> Number of  Applicants: <span class="badge bg-primary">
       {{ $applicantCount }} {{ $applicantCount !== 1 ? 's' : '' }}
    </span> </p>

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Resume</th>
                <th>Cover Letter</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($career->applications as $applicant)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $applicant->name }}</td>
                <td>{{ $applicant->email }}</td>
                <td>{{ $applicant->phone }}</td>

                {{-- ✅ View + Download Resume --}}
                <td>
                    @if($applicant->resume)
                        <div class="btn-group">
                            <a href="{{ asset($applicant->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ asset($applicant->resume) }}" download class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
            <!-- Cover letter button -->
               <td>
                    <!-- View Button -->
                    <button type="button" 
                            class="btn btn-sm btn-outline-primary ms-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="#viewCoverLetterModal{{ $applicant->id }}">
                        <i class="bi bi-eye"></i> View
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="viewCoverLetterModal{{ $applicant->id }}" tabindex="-1" 
                        aria-labelledby="viewCoverLetterLabel{{ $applicant->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content shadow-lg border-0 rounded-4">
                                <div class="modal-header" style="background: maroon; color: white; padding: 8px 16px;">
                                    <h5 class="modal-title fw-bold" id="viewCoverLetterLabel{{ $applicant->id }}">
                                        <i class="bi bi-envelope-open me-2"></i> Cover Letter
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                    <p class="text-secondary" style="white-space: pre-wrap;">
                                        {{ $applicant->cover_letter }}
                                    </p>
                                </div>
                                <div class="modal-footer d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle"></i> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                {{-- ✅ Applicant Status Badge --}}
                <td>
                    <span class="badge 
                        @if($applicant->status == 'Pending') bg-secondary
                        @elseif($applicant->status == 'Reviewed') bg-info
                        @elseif($applicant->status == 'Shortlisted') bg-success
                        @elseif($applicant->status == 'Rejected') bg-danger
                        @endif">
                        {{ $applicant->status }}
                    </span>
                </td>

                {{-- ✅ Inline Status Update Dropdown --}}
                <td>
                    <form method="POST" action="{{ route('admin.applications.update', $applicant->id) }}">
                        @csrf
                        <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                            <option value="Pending" {{ $applicant->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Reviewed" {{ $applicant->status == 'Reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="Shortlisted" {{ $applicant->status == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="Rejected" {{ $applicant->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No applicants yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
