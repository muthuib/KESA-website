@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-eye me-2"></i> Career Opportunity Details
            </h5>
            <a href="{{ route('admin.careers.index') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="fw-bold">Job Title:</h6>
                    <p>{{ $career->title }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Department:</h6>
                    <p>{{ $career->department }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Location:</h6>
                    <p>{{ $career->location }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Job Type:</h6>
                    <p>{{ $career->job_type }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Application Deadline:</h6>
                    <p>{{ \Carbon\Carbon::parse($career->deadline)->format('F j, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Status:</h6>
                    @if($career->status === 'Open')
                        <span class="badge bg-success px-3 py-2">{{ $career->status }}</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">{{ $career->status }}</span>
                    @endif
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <h6 class="fw-bold">Description:</h6>
                <p class="text-muted">{!! nl2br(e($career->description)) !!}</p>
            </div>

            <div class="mb-3">
                <h6 class="fw-bold">Requirements:</h6>
                <p class="text-muted">{!! nl2br(e($career->requirements)) !!}</p>
            </div>

            <div class="mb-3">
                <h6 class="fw-bold">Responsibilities:</h6>
                <p class="text-muted">{!! nl2br(e($career->responsibilities)) !!}</p>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('admin.careers.destroy', $career->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this opportunity?');">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
