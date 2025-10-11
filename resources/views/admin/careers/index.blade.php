@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">Manage Career Opportunities</h4>

    <div class="mb-3 text-end">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCareerModal">+ Add New Career</a>
    </div>

    <table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Department</th>
            <th>Location</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Applicants</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($careers as $index => $career)
        <tr>
            <td>{{ $loop->iteration }}.</td>
            <td>{{ $career->title }}</td>
            <td>{{ $career->department }}</td>
            <td>{{ $career->location }}</td>
            <td>{{ \Carbon\Carbon::parse($career->deadline)->format('d M Y') }}</td>
            <td>
                <span class="badge bg-{{ $career->status == 'Open' ? 'success' : 'danger' }}">
                    {{ $career->status }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.careers.applicants', $career->id) }}" 
                   class="btn btn-sm btn-outline-primary">
                   <i class="bi bi-people-fill"></i> Applicants
                </a>
            </td>
            <td class="text-center">
                <div class="btn-group" role="group">
                    <!-- View -->
                    <a href="{{ route('admin.careers.show', $career->id) }}" 
                       class="btn btn-sm btn-outline-info" 
                       data-bs-toggle="tooltip" title="View Details">
                        <i class="bi bi-eye-fill"></i>
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('admin.careers.edit', $career->id) }}" 
                       class="btn btn-sm btn-outline-warning" 
                       data-bs-toggle="tooltip" title="Edit Job">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('admin.careers.destroy', $career->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this job?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                data-bs-toggle="tooltip" title="Delete Job">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted">No career opportunities available.</td>
        </tr>
        @endforelse
    </tbody>
</table>

    {{ $careers->links() }}
</div>

<!-- Add Career Modal -->
<div class="modal fade" id="addCareerModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <!-- Header -->
      <div class="modal-header py-3" style="background: maroon;">
        <h5 class="modal-title w-100 text-center text-white fw-bold">
          <i class="bi bi-briefcase-fill me-2"></i> Add Career Opportunity
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('admin.careers.store') }}">
        @csrf
        <div class="modal-body px-4 py-3">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Job Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control modern-input" placeholder="Enter job title" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Department</label>
              <input type="text" name="department" class="form-control modern-input" placeholder="e.g. Human Resources">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Location</label>
              <input type="text" name="location" class="form-control modern-input" placeholder="e.g. Nairobi, Kenya">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Job Type</label>
              <select name="job_type" class="form-select modern-input">
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Internship</option>
                <option>Contract</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Deadline <span class="text-danger">*</span></label>
              <input type="date" name="deadline" class="form-control modern-input" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-secondary">Status</label>
              <input type="text" name="status" class="form-control modern-input bg-light" value="Open" readonly>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-secondary">Description <span class="text-danger">*</span></label>
              <textarea name="description" rows="3" class="form-control modern-input" placeholder="Briefly describe the job role..." required></textarea>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-secondary">Requirements</label>
              <textarea name="requirements" rows="3" class="form-control modern-input" placeholder="List required qualifications or skills..."></textarea>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-secondary">Responsibilities</label>
              <textarea name="responsibilities" rows="3" class="form-control modern-input" placeholder="Outline main responsibilities..."></textarea>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="submit" class="btn btn-lg w-100 fw-bold text-white shadow submit-btn">
            <i class="bi bi-plus-circle me-2"></i> Add Opportunity
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Custom Styles -->
<style>
    /* Modal animation */
    .modal-content {
      animation: fadeInUp 0.4s ease;
    }

    @keyframes fadeInUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Modern input design */
    .modern-input {
      border: 2px solid #e0e0e0;
      border-radius: 0.5rem;
      transition: all 0.25s ease-in-out;
    }

    .modern-input:focus {
      border-color: maroon;
      box-shadow: 0 0 0 0.25rem rgba(128, 0, 0, 0.2);
    }

    /* Submit button gradient */
    .submit-btn {
      background: green;
      border: none;
      transition: all 0.3s ease;
    }

    .submit-btn:hover {
      transform: scale(1.02);
      background: #174218ff;
    }

    /* Form label consistency */
    .form-label {
      font-size: 0.95rem;
      letter-spacing: 0.3px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
