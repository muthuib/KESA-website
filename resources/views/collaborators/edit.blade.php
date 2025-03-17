@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-left" style="font-size: 30px;">Edit Partner/Collaborator</h1>
    <!-- Back button with a backward icon -->
    <div class="mb-3 text-end">
        <a href="{{ route('collaborators.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('collaborators.update', $collaborator->ID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Collaborator Name</label> <!-- Added fw-bold class -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $collaborator->NAME) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="mb-3">
                            <label for="logo" class="form-label fw-bold">Logo</label> <!-- Added fw-bold class -->
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            <small class="text-muted">Leave blank to keep the current logo.</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Logo Preview -->
                        <div class="mb-3">
                        <img src="{{ asset($collaborator->LOGO_PATH) }}" 
                        alt="{{ $collaborator->NAME }}" 
                        style="width: 50px; height: 50px; object-fit: contain;">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label> <!-- Added fw-bold class -->
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $collaborator->DESCRIPTION) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div class="mb-3">
                            <label for="website" class="form-label fw-bold">Website</label> <!-- Added fw-bold class -->
                            <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $collaborator->WEBSITE) }}">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Collaborator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
