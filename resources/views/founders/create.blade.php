@extends('layouts.app')

@section('content')
<div class="container my-5" style="margin-top: 90px;">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
        <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
    </a>
    
    <h2 class="text-center mb-4">Add New Founder</h2>

    <form action="{{ route('founders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" name="designation" id="designation" class="form-control" required>
            @error('designation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" id="bio" rows="4" class="form-control"></textarea>
            @error('bio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cv_link" class="form-label">CV Link</label>
            <input type="url" name="cv_link" id="cv_link" class="form-control">
            @error('cv_link')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> -->

        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Add Founder Member</button>
    </form>
</div>
@endsection
