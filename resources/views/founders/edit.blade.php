@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px;">
    <h2 class="text-center mb-4">Edit Founder</h2>
    <!-- Back Button at top right -->
    <a href="{{ url()->previous() }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
    </a>
    <form action="{{ route('founders.update', $founder->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $founder->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation', $founder->designation) }}" required>
            @error('designation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" id="bio" rows="4" class="form-control">{{ old('bio', $founder->bio) }}</textarea>
            @error('bio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="cv_link" class="form-label">CV Link</label>
            <input type="url" name="cv_link" id="cv_link" class="form-control" value="{{ old('cv_link', $founder->cv_link) }}">
            @error('cv_link')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> -->
        
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            @if($founder->image)
                <div class="mb-2">
                    <img src="{{ asset($founder->image) }}" alt="{{ $founder->name }}" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Update Founder Member</button>
    </form>
</div>
@endsection
