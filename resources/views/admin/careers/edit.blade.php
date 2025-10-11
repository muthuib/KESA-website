@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i> Edit Career Opportunity
            </h5>
            <a href="{{ route('admin.careers.index') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.careers.update', $career->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Job Title</label>
                        <input type="text" name="title" value="{{ old('title', $career->title) }}" 
                               class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Department</label>
                        <input type="text" name="department" value="{{ old('department', $career->department) }}" 
                               class="form-control @error('department') is-invalid @enderror">
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Location</label>
                        <input type="text" name="location" value="{{ old('location', $career->location) }}" 
                               class="form-control @error('location') is-invalid @enderror">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Job Type</label>
                        <select name="job_type" class="form-select @error('job_type') is-invalid @enderror">
                            <option value="Full-time" {{ old('job_type', $career->job_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('job_type', $career->job_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Internship" {{ old('job_type', $career->job_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                            <option value="Contract" {{ old('job_type', $career->job_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                        @error('job_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Deadline</label>
                        <input type="date" name="deadline" 
                               value="{{ old('deadline', \Carbon\Carbon::parse($career->deadline)->format('Y-m-d')) }}" 
                               class="form-control @error('deadline') is-invalid @enderror" required>
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Status</label>

                        <!-- Disabled visible select -->
                        <select class="form-select modern-input bg-light" disabled>
                            <option value="Open" {{ old('status', $career->status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('status', $career->status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>

                        <!-- Hidden input to actually submit the value -->
                        <input type="hidden" name="status" value="{{ old('status', $career->status) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $career->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Requirements</label>
                        <textarea name="requirements" rows="3" 
                                  class="form-control @error('requirements') is-invalid @enderror">{{ old('requirements', $career->requirements) }}</textarea>
                        @error('requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Responsibilities</label>
                        <textarea name="responsibilities" rows="3" 
                                  class="form-control @error('responsibilities') is-invalid @enderror">{{ old('responsibilities', $career->responsibilities) }}</textarea>
                        @error('responsibilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Update Career
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
