@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-left" style="font-size: 30px;">Edit Membership</h1>
    
    <!-- Back button -->
    <div class="mb-3 text-end">
        <a href="{{ route('memberships.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                <form action="{{ route('memberships.update', ['membership' => $membership->ID]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Membership Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" 
                                   value="{{ old('name', $membership->NAME) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div class="mb-3">
                            <label for="logo" class="form-label fw-bold">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            <small class="text-muted">Leave blank to keep the current logo.</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Logo Preview -->
                        <div class="mb-3">
                            @if($membership->LOGO_PATH)
                                <img src="{{ asset($membership->LOGO_PATH) }}" alt="Membership Logo" 
                                     style="width: 70px; height: 70px; object-fit: contain;">
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" 
                                      rows="3">{{ old('description', $membership->DESCRIPTION) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div class="mb-3">
                            <label for="website" class="form-label fw-bold">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" name="website" 
                                   value="{{ old('website', $membership->WEBSITE) }}">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Membership</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
