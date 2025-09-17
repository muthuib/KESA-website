@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Profile</h2>
    <form action="{{ route('profile.update', $user->ID) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
        @csrf
        @method('PUT')

    
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="FIRST_NAME" class="form-label">First Name *</label>
                <input id="FIRST_NAME" type="text" name="FIRST_NAME" value="{{ old('FIRST_NAME', $user->FIRST_NAME) }}" required class="form-control">
                @error('FIRST_NAME') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="LAST_NAME" class="form-label">Last Name *</label>
                <input id="LAST_NAME" type="text" name="LAST_NAME" value="{{ old('LAST_NAME', $user->LAST_NAME) }}" required class="form-control">
                @error('LAST_NAME') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="MIDDLE_NAME" class="form-label">Middle Name *</label>
                <input id="MIDDLE_NAME" type="text" name="MIDDLE_NAME" value="{{ old('MIDDLE_NAME', $user->MIDDLE_NAME) }}" class="form-control">
                @error('MIDDLE_NAME') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="EMAIL" class="form-label">Email *</label>
                <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL', $user->EMAIL) }}" required class="form-control">
                @error('EMAIL') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="NATIONAL_ID_NUMBER" class="form-label">National ID Number *</label>
                <input type="text" id="NATIONAL_ID_NUMBER" name="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER', $user->NATIONAL_ID_NUMBER) }}" required class="form-control">
                @error('NATIONAL_ID_NUMBER') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="PHONE_NUMBER" class="form-label">Phone Number *</label>
                <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER', $user->PHONE_NUMBER) }}" required class="form-control">
                @error('PHONE_NUMBER') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="GENDER" class="form-label">Gender *</label>
            <select id="GENDER" name="GENDER" required class="form-select">
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('GENDER', $user->GENDER) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('GENDER', $user->GENDER) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('GENDER') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Do you have any form of disability? *</label>
            <div>
                <input type="radio" id="DISABILITY_YES" name="DISABILITY_STATUS" value="Yes" class="form-check-input" {{ old('DISABILITY_STATUS', $user->DISABILITY_STATUS) == 'Yes' ? 'checked' : '' }}>
                <label for="DISABILITY_YES" class="form-check-label">Yes</label>

                <input type="radio" id="DISABILITY_NO" name="DISABILITY_STATUS" value="No" class="form-check-input" {{ old('DISABILITY_STATUS', $user->DISABILITY_STATUS) == 'No' ? 'checked' : '' }}>
                <label for="DISABILITY_NO" class="form-check-label">No</label>
            </div>
        </div>

        <div id="disability_type" class="mb-3" style="display: {{ old('DISABILITY_STATUS', $user->DISABILITY_STATUS) == 'Yes' ? 'block' : 'none' }}">
            <label for="DISABILITY_TYPE" class="form-label">Type of Disability *</label>
            <input type="text" id="DISABILITY_TYPE" name="DISABILITY_TYPE" value="{{ old('DISABILITY_TYPE', $user->DISABILITY_TYPE) }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Are you currently in school? *</label>
            <label for="SCHOOL_YES">Yes</label>
            <input type="radio" id="SCHOOL_YES" name="CURRENTLY_IN_SCHOOL" value="Yes" 
                {{ old('CURRENTLY_IN_SCHOOL', $user->CURRENTLY_IN_SCHOOL) == 'Yes' ? 'checked' : '' }} >

            <label for="SCHOOL_NO">No</label>
            <input type="radio" id="SCHOOL_NO" name="CURRENTLY_IN_SCHOOL" value="No" 
                {{ old('CURRENTLY_IN_SCHOOL', $user->CURRENTLY_IN_SCHOOL) == 'No' ? 'checked' : '' }} >
        </div>

        <div id="school_info" class="p-4 border rounded bg-light" style="display: {{ old('CURRENTLY_IN_SCHOOL', $user->CURRENTLY_IN_SCHOOL) == 'Yes' ? 'block' : 'none' }};">
            <h5 class="text-primary">School Information</h5>

            <!-- Highest Level of Education -->
            <div class="mb-3">
                <label for="HIGHEST_LEVEL" class="form-label fw-bold">Which level? *</label>
                <select id="HIGHEST_LEVEL" name="HIGHEST_LEVEL_SCHOOL_ATTENDING" class="form-select">
                    <option value="" disabled selected>Select level</option>
                    <option value="TVET College" {{ old('HIGHEST_LEVEL_SCHOOL_ATTENDING', $user->HIGHEST_LEVEL_SCHOOL_ATTENDING) == 'TVET College' ? 'selected' : '' }}>TVET College</option>
                    <option value="University" {{ old('HIGHEST_LEVEL_SCHOOL_ATTENDING', $user->HIGHEST_LEVEL_SCHOOL_ATTENDING) == 'University' ? 'selected' : '' }}>University</option>
                </select>
            </div>

            <!-- School Name -->
            <div class="mb-3">
                <label for="SCHOOL_NAME" class="form-label fw-bold">Name of School *</label>
                <input type="text" id="SCHOOL_NAME" name="SCHOOL_NAME" value="{{ old('SCHOOL_NAME', $user->SCHOOL_NAME) }}" class="form-control" placeholder="Enter school name">
            </div>

            <!-- Program of Study -->
            <div class="mb-3">
                <label for="PROGRAM_OF_STUDY" class="form-label fw-bold">Program of Study *</label>
                <input type="text" id="PROGRAM_OF_STUDY" name="PROGRAM_OF_STUDY" value="{{ old('PROGRAM_OF_STUDY', $user->PROGRAM_OF_STUDY) }}" class="form-control" placeholder="Enter program of study">
            </div>

            <!-- Registration Number -->
            <div class="mb-3">
                <label for="SCHOOL_REGISTRATION_NUMBER" class="form-label fw-bold">Registration Number *</label>
                <input type="text" id="SCHOOL_REGISTRATION_NUMBER" name="SCHOOL_REGISTRATION_NUMBER" value="{{ old('SCHOOL_REGISTRATION_NUMBER', $user->SCHOOL_REGISTRATION_NUMBER) }}" class="form-control" placeholder="Enter registration number">
            </div>
        </div>

        <div id="non_school_info" style="display: {{ old('CURRENTLY_IN_SCHOOL', $user->CURRENTLY_IN_SCHOOL) == 'No' ? 'block' : 'none' }}">
        <div id="previous_school_info" class="p-4 border rounded bg-light">
                <h5 class="text-primary">Previous Education</h5>

                <!-- Name of Previous School -->
                <div class="mb-3">
                    <label for="PREVIOUS_SCHOOL_NAME" class="form-label fw-bold">Name of Previous School *</label>
                    <input type="text" id="PREVIOUS_SCHOOL_NAME" name="PREVIOUS_SCHOOL_NAME" value="{{ old('PREVIOUS_SCHOOL_NAME', $user->PREVIOUS_SCHOOL_NAME) }}" class="form-control" placeholder="Enter previous school name">
                </div>

                <!-- Previous Program of Study -->
                <div class="mb-3">
                    <label for="PREVIOUS_PROGRAM_OF_STUDY" class="form-label fw-bold">Program of Study *</label>
                    <input type="text" id="PREVIOUS_PROGRAM_OF_STUDY" name="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY', $user->PREVIOUS_PROGRAM_OF_STUDY) }}" class="form-control" placeholder="Enter program of study">
                </div>

                <!-- Education Level -->
                <div class="mb-3">
                    <label for="EDUCATION_LEVEL" class="form-label fw-bold">What level? *</label>
                    <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" class="form-select">
                        <option value="" disabled selected>Select level</option>
                        <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) == 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                        <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) == 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                        <option value="Masters Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) == 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                        <option value="PhD" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) == 'PhD' ? 'selected' : '' }}>PhD</option>
                    </select>
                </div>
            </div>
        </div><br>
        <div class="mb-3">
            <label for="PASSPORT_PHOTO" class="form-label">Upload Passport Sized Photo</label><br>
            <img src="{{ asset($user->PASSPORT_PHOTO) }}" 
                class="card-img-top rounded-circle" 
                alt="Upload profile Picture" 
                style="width: 50px; height: 50px; object-fit: cover;">
            <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" accept=".jpeg,.png,.jpg" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
</div>

<script>
    document.querySelectorAll('input[name="DISABILITY_STATUS"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('disability_type').style.display = this.value === 'Yes' ? 'block' : 'none';
        });
    });

    document.querySelectorAll('input[name="CURRENTLY_IN_SCHOOL"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('school_info').style.display = this.value === 'Yes' ? 'block' : 'none';
            document.getElementById('non_school_info').style.display = this.value === 'No' ? 'block' : 'none';
        });
    });
</script>
@endsection
