@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4 text-center text-primary">Career Opportunities</h3>

    <!-- 🔍 Filter Bar -->
    <form method="GET" class="d-flex flex-wrap justify-content-center mb-4">
        <input type="text" name="search" class="form-control me-2 mb-2 w-25"
               placeholder="Search job title..." value="{{ $search ?? '' }}">
        <input type="text" name="location" class="form-control me-2 mb-2 w-25"
               placeholder="Location..." value="{{ $location ?? '' }}">
        <input type="text" name="department" class="form-control me-2 mb-2 w-25"
               placeholder="Department..." value="{{ $department ?? '' }}">
        <button class="btn btn-primary mb-2">
            <i class="bi bi-filter-circle"></i> Filter
        </button>
    </form>

    <div class="row g-4">
        @forelse($careers as $career)
           @php
                $deadline = \Carbon\Carbon::parse($career->deadline)->endOfDay();
                $now = \Carbon\Carbon::now();
                $daysLeft = $now->diffInDays($deadline, false);
            @endphp


            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow transition-all">
                    <div class="card-body">
                        <h5 class="fw-bold text-dark">{{ $career->title }}</h5>
                        <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ $career->location ?? 'Unspecified' }}</p>
                        <p class="small mb-1"><i class="bi bi-building"></i> {{ $career->department ?? 'General' }}</p>
                        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($career->deadline)->format('d M Y') }}</p>

                        <!-- 🕒 Deadline badge -->
                        @if($daysLeft > 0)
                                <span class="badge bg-success mb-2">
                                    <i class="bi bi-clock-history"></i> {{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }} left
                                </span>
                            @elseif($daysLeft === 0)
                                <span class="badge bg-warning text-dark mb-2">
                                    <i class="bi bi-exclamation-circle"></i> Closes today
                                </span>
                            @else
                                <span class="badge bg-danger mb-2">
                                    <i class="bi bi-x-circle"></i> Closed
                                </span>
                            @endif

                        <!-- <p class="text-truncate">{{ Str::limit($career->description, 100) }}</p> -->

                        <div class="d-flex gap-2 mt-3">
                            <!-- 🕵️ Show More -->
                            <button class="btn btn-sm btn-outline-info flex-grow-1"
                                    data-bs-toggle="modal" data-bs-target="#detailsModal{{ $career->id }}">
                                <i class="bi bi-eye"></i> Show Job Details
                            </button>

                            <!-- 📨 Apply Button -->
                            @if($daysLeft < 0)
                                <button class="btn btn-sm btn-outline-secondary flex-grow-1" disabled>
                                    <i class="bi bi-lock"></i> Closed
                                </button>
                            @else
                                @auth
                                    @php
                                        $hasApplied = \App\Models\CareerApplication::where('career_id', $career->id)
                                            ->where('email', auth()->user()->EMAIL)
                                            ->exists();
                                    @endphp

                                    @if($hasApplied)
                                        <button class="btn btn-sm btn-success flex-grow-1" disabled>
                                            <i class="bi bi-check-circle"></i> Applied
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-primary flex-grow-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#applyModal{{ $career->id }}">
                                            <i class="bi bi-send"></i> Apply
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#applyModal{{ $career->id }}">
                                        <i class="bi bi-send"></i> Apply Now
                                    </button>
                                @endauth
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!-- 📋 Job Details Modal -->
            <div class="modal fade" id="detailsModal{{ $career->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $career->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4">
                        <div class="modal-header" style="background: maroon; color: white; padding-top: 0.4rem; padding-bottom: 0.4rem;">
                            <h5 class="modal-title fw-bold" id="detailsModalLabel{{ $career->id }}">
                                {{ $career->title }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Department:</strong> {{ $career->department ?? 'General' }}</p>
                            <p><strong>Location:</strong> {{ $career->location ?? 'Unspecified' }}</p>
                            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($career->deadline)->format('d M Y') }}</p>

                            <hr>
                            <h6 class="fw-bold">Job Description</h6>
                            <p>{!! nl2br(e($career->description)) !!}</p>

                            @if($career->requirements)
                                <h6 class="fw-bold mt-3">Requirements</h6>
                                <p>{!! nl2br(e($career->requirements)) !!}</p>
                            @endif
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2 border-0 pt-3">
                            <!-- Close Button -->
                            <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Close
                            </button>

                            <!-- Apply Button -->
                            @if($daysLeft < 0)
                                <button class="btn btn-outline-secondary px-4" disabled>
                                    <i class="bi bi-lock"></i> Closed
                                </button>
                            @else
                                @auth
                                    @php
                                        $hasApplied = \App\Models\CareerApplication::where('career_id', $career->id)
                                            ->where('email', auth()->user()->EMAIL)
                                            ->exists();
                                    @endphp

                                    @if($hasApplied)
                                        <button class="btn btn-success px-4" disabled>
                                            <i class="bi bi-check-circle"></i> Applied
                                        </button>
                                    @else
                                        <button class="btn btn-primary px-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#applyModal{{ $career->id }}">
                                            <i class="bi bi-send"></i> Apply
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-outline-primary px-4"
                                            data-bs-toggle="modal"
                                            data-bs-target="#applyModal{{ $career->id }}">
                                        <i class="bi bi-send"></i> Apply Now
                                    </button>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📝 Apply Modal -->
            <div class="modal fade" id="applyModal{{ $career->id }}" tabindex="-1" aria-labelledby="applyModalLabel{{ $career->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-4">

                    <!-- Modal Header -->
                    <div class="modal-header" style="background: maroon; color: white; padding-top: 0.4rem; padding-bottom: 0.4rem;">
                            <h4 class="modal-title fw-bold">
                                <i class="bi bi-briefcase-fill me-2 text-center"></i>Apply for {{ $career->title }}
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                     </div>
  
                    @auth
                    <form method="POST" action="{{ route('careers.apply', $career->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body px-4 py-3">

                        <!-- Motivational message -->
                        <div class="alert alert-info d-flex align-items-center" role="alert" style="background: #eaf4ff; border-left: 4px solid #007bff;">
                            <i class="bi bi-stars me-2 fs-4 text-primary"></i>
                            <div>
                            <strong>You're one step closer!</strong> Great opportunities await — make sure your application stands out.
                            </div>
                        </div>

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" name="name" class="form-control border-2 rounded-3"
                                value="{{ auth()->user()->FIRST_NAME }}" 
                                style="background-color: #e9ecef;" readonly>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Email</label>
                            <input type="email" name="email" class="form-control border-2 rounded-3"
                                value="{{ auth()->user()->EMAIL }}" 
                                style="background-color: #e9ecef;" readonly>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Phone Number</label>
                            <input type="text" name="phone" class="form-control border-2 rounded-3"
                                value="{{ auth()->user()->PHONE_NUMBER ?? '' }}" 
                                style="background-color: #e9ecef;" readonly>
                        </div>

                        <!-- Resume -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Resume (PDF/DOC)</label>
                            <input type="file" name="resume" class="form-control border-2 rounded-3" 
                                accept=".pdf,.doc,.docx" required>
                            <small class="text-muted">Upload a professional and updated version of your resume.</small>
                        </div>
                    </div>


                        <!-- Cover Letter -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Cover Letter</label>
                            <textarea name="cover_letter" class="form-control border-2 rounded-3" rows="4" placeholder="Write a short cover letter to express your interest..."></textarea>
                        </div>

                        </div>

                        <!-- Footer -->
                        <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-lg w-100 fw-bold text-white shadow"
                                style="background: linear-gradient(135deg, #28a745, #20c997); border: none;">
                            <i class="bi bi-send-fill me-2"></i> Submit Application
                        </button>
                        </div>
                    </form>

                    @else
                    <div class="modal-body text-center py-5">
                        <i class="bi bi-lock display-4 text-warning mb-3"></i>
                        <h5 class="fw-bold mb-2 text-dark">Login Required</h5>
                        <p class="text-muted mb-4">Please log in to apply for this job opportunity.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 py-2">
                        <i class="bi bi-box-arrow-in-right"></i> Go to Login
                        </a>
                    </div>
                    @endauth
                    </div>
                </div>
                </div>

        @empty
            <p class="text-center text-muted">No open positions currently.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $careers->links() }}
    </div>
</div>

<style>
    /* Make all labels bold and consistent */
    .form-label {
    font-weight: 600;
    color: #333;
    position: relative;
    display: inline-block;
    }

    /* Add red asterisk for required fields */
    .form-label::after {
    content: " *";
    color: red;
    font-weight: bold;
    display: ${({ required }) => (required ? 'inline' : 'none')};
    }

</style>
@endsection
