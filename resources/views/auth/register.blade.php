<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        background-image: url('pictures/econ.jpg'); /* Add the background image URL */
        background-size: cover;
        background-position: center center;
        background-attachment: fixed;
    }

    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 50px;
        min-height: 100%;
    }

    .register-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 800px;
        height: auto; /* Allow height to adjust based on content */
        margin-top: 70px;
        
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        position: relative; /* Required for the asterisk positioning */
    }

    .form-group input[required]::before, 
    .form-group select[required]::before, 
    .form-group textarea[required]::before {
        content: ' *'; /* Asterisk character */
        color: red; /* Asterisk color set to red */
        font-size: 14px; /* Font size */
        font-weight: bold; /* Bold font weight */
        position: absolute; /* Position asterisk to the left */
        left: 5px; /* Position it correctly */
        top: 50%; /* Center asterisk vertically */
        transform: translateY(-50%); /* Center asterisk vertically */
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    .success {
        color: #155724;
        background-color: #d4edda;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #c3e6cb;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
    /* Logo container */
    .logo-container {
        display: flex;
        justify-content: center; /* Center the logo horizontally */
        margin-top: 10px; /* Add some top margin */
    }

    /* Logo image */
    .logo {
        width: 140px; /* Default size for larger screens */
        height: auto; /* Maintain aspect ratio */
    }

    /* Responsive adjustments for small devices */
    @media (max-width: 768px) {
        .register-wrapper {
            padding-top: 20px; /* Reduce padding for smaller screens */
            
        }

        .register-container {
            padding: 15px; /* Reduce padding for smaller screens */
            margin: 10px; /* Reduce margin for smaller screens */
            margin-top: 70px;
            width: 450px;
            
        }

        .register-container h2 {
            font-size: 1.0rem; /* Reduce heading size for smaller screens */
        }

        .form-row {
            flex-direction: column; /* Stack form fields vertically on small screens */
            gap: 7px; /* Reduce gap between stacked fields */
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 8px; /* Reduce padding for smaller screens */
            font-size: 10px; /* Reduce font size for smaller screens */
        }

        button[type="submit"] {
            padding: 10px; /* Reduce button padding for smaller screens */
            font-size: 10px; /* Reduce button font size for smaller screens */
        }

        .success,
        .error {
            font-size: 10px; /* Reduce font size for messages */
        }
    }
    /* Logo adjustments for small screens */
        .logo-container {
            text-align: center; /* Center the logo horizontally */
        }
        .logo {
            width: 100px; /* Reduce logo size for small screens */
            margin-left: 0; /* Remove left margin */
        }
        
    /* Further adjustments for very small devices (e.g., phones) */
    @media (max-width: 480px) {
        .register-container {
            padding: 10px; /* Further reduce padding for very small screens */
            margin-top: 70px;
            width: 400px;
        }

        .register-container h2 {
            font-size: 0.80rem; /* Further reduce heading size */
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 6px; /* Further reduce padding for very small screens */
            font-size: 12px; /* Further reduce font size for very small screens */
        }

        button[type="submit"] {
            padding: 8px; /* Further reduce button padding for very small screens */
            font-size: 10px; /* Further reduce button font size for very small screens */
        }
        .logo {
            width: 80px; /* Further reduce logo size for very small screens */
        }
    }
</style>
</head>

<body>
    <!-- Include the top navigation bar -->
    @include('dashboard.topnav')

    <div class="register-wrapper">
        <div class="register-container">
            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif
           <!-- Display errors if any -->
           @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Logo -->
            <div class="logo-container">
                <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" class="logo img-fluid">
            </div>

            <h2 style="color:rgb(61, 15, 81);">KESA Member Registration</h2>
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    
                <div class="form-group">
                        <label for="FIRST_NAME">First Name *</label>
                        <input id="FIRST_NAME" type="text" name="FIRST_NAME" value="{{ old('FIRST_NAME') }}" required>
                        @error('FIRST_NAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="form-group">
                        <label for="LAST_NAME">Last Name *</label>
                        <input id="LAST_NAME" type="text" name="LAST_NAME" value="{{ old('LAST_NAME') }}" required>
                        @error('LAST_NAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="MIDDLE_NAME">Middle Name *</label>
                        <input id="MIDDLE_NAME" type="text" name="MIDDLE_NAME" value="{{ old('MIDDLE_NAME') }}" required>
                        @error('MIDDLE_NAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>           
                </div>
              <!-- row-->
              <div class="form-row">
                      <!-- Email -->
                      <div class="form-group">
                        <label for="EMAIL">Email *</label>
                        <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" required>
                        @error('EMAIL')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="NATIONAL_ID_NUMBER">National ID Number *</label>
                        <input type="text" id="NATIONAL_ID_NUMBER" name="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER') }}" required>
                        @error('NATIONAL_ID_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Password and Confirm Password -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="PASSWORD">Password *</label>
                        <input type="password" id="PASSWORD" name="PASSWORD" required>
                        @error('PASSWORD')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="PASSWORD_CONFIRMATION">Confirm Password *</label>
                        <input type="password" id="PASSWORD_CONFIRMATION" name="PASSWORD_CONFIRMATION" required>
                        @error('PASSWORD_CONFIRMATION')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--   Row -->
                <div class="form-row">
                  

                    <div class="form-group">
                        <label for="GENDER">Gender *</label>
                        <select id="GENDER" name="GENDER" required>
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('GENDER') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('GENDER') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('GENDER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="PHONE_NUMBER">Phone Number *</label>
                        <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER') }}" required>
                        @error('PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ALTERNATIVE_PHONE_NUMBER">Alternative Phone Number</label>
                        <input type="text" id="ALTERNATIVE_PHONE_NUMBER" name="ALTERNATIVE_PHONE_NUMBER" value="{{ old('ALTERNATIVE_PHONE_NUMBER') }}">
                    </div>
                </div>

                <!-- Disability related question -->
                <div class="form-group">
                    <label for="DISABILITY_STATUS">Do you have any form of disability? *</label>
                    <label for="DISABILITY_YES">Yes</label>
                    <input type="radio" id="DISABILITY_YES" name="DISABILITY_STATUS" value="Yes" {{ old('DISABILITY_STATUS') == 'Yes' ? 'checked' : '' }}>
                    <label for="DISABILITY_NO">No</label>
                    <input type="radio" id="DISABILITY_NO" name="DISABILITY_STATUS" value="No" {{ old('DISABILITY_STATUS') == 'No' ? 'checked' : '' }}>
                </div>

                <!-- Disability type -->
                <div id="disability_type" style="display: {{ old('DISABILITY_STATUS') == 'Yes' ? 'block' : 'none' }}">
                    <div class="form-group">
                        <label for="DISABILITY_TYPE">Type of Disability *</label>
                        <input type="text" id="DISABILITY_TYPE" name="DISABILITY_TYPE" value="{{ old('DISABILITY_TYPE') }}">
                    </div>
                </div>

                <!-- Passport photo -->
                <div class="form-group">
                    <label for="PASSPORT_PHOTO">Upload Passport Sized Photo * Images should be in format: jpeg, png, jpg</label>
                    <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" accept=".jpeg,.png,.jpg" required>
                </div>
                <!-- School status -->
                <div class="form-group">
                <label>Are you currently in school? *</label>
                <label for="SCHOOL_YES">Yes</label>
                <input type="radio" id="SCHOOL_YES" name="CURRENTLY_IN_SCHOOL" value="Yes" 
                    {{ old('CURRENTLY_IN_SCHOOL') == 'Yes' ? 'checked' : '' }} >

                <label for="SCHOOL_NO">No</label>
                <input type="radio" id="SCHOOL_NO" name="CURRENTLY_IN_SCHOOL" value="No" 
                    {{ old('CURRENTLY_IN_SCHOOL') == 'No' ? 'checked' : '' }} >
            </div>


                <div id="school_info" style="display: {{ old('SCHOOL_STATUS') == 'Yes' ? 'block' : 'none' }}">
                    <!-- School related fields for users currently in school -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="HIGHEST_LEVEL">Which level? *</label>
                            <select id="HIGHEST_LEVEL" name="HIGHEST_LEVEL_SCHOOL_ATTENDING">
                                <option value="" disabled selected>Select level</option>
                                <option value="TVET College" {{ old('HIGHEST_LEVEL_SCHOOL_ATTENDING') == 'TVET College' ? 'selected' : '' }}>TVET College</option>
                                <option value="University" {{ old('HIGHEST_LEVEL_SCHOOL_ATTENDING') == 'University' ? 'selected' : '' }}>University</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="SCHOOL_NAME">Name of School *</label>
                            <input type="text" id="SCHOOL_NAME" name="SCHOOL_NAME" value="{{ old('SCHOOL_NAME') }}">
                        </div>
                        <div class="form-group">
                            <label for="PROGRAM_OF_STUDY">Program of Study *</label>
                            <input type="text" id="PROGRAM_OF_STUDY" name="PROGRAM_OF_STUDY" value="{{ old('PROGRAM_OF_STUDY') }}">
                        </div>
                        <div class="form-group">
                            <label for="SCHOOL_REGISTRATION_NUMBER">Registration Number *</label>
                            <input type="text" id="SCHOOL_REGISTRATION_NUMBER" name="SCHOOL_REGISTRATION_NUMBER" value="{{ old('SCHOOL_REGISTRATION_NUMBER') }}">
                        </div>
                    </div>
                    <p>Please send registration fee of KE.300 to M-Pesa Business No: 522533 Account No:7782321#mreg</p>
                    <div class="form-group">
                        <label for="REGISTRATION_FEE">Registration Fee (KES) *</label>
                        <input type="text" id="REGISTRATION_FEE" name="REGISTRATION_FEE" value="{{ old('REGISTRATION_FEE') }}" >
                        @error('REGISTRATION_FEE')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="non_school_info" style="display: {{ old('SCHOOL_STATUS') == 'No' ? 'block' : 'none' }}">
                    <!-- School related fields for users not currently in school -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="PREVIOUS_SCHOOL_NAME">Name of Previous School *</label>
                            <input type="text" id="PREVIOUS_SCHOOL_NAME" name="PREVIOUS_SCHOOL_NAME" value="{{ old('PREVIOUS_SCHOOL_NAME') }}">
                        </div>
                        <div class="form-group">
                            <label for="PREVIOUS_PROGRAM_OF_STUDY">Program of Study *</label>
                            <input type="text" id="PREVIOUS_PROGRAM_OF_STUDY" name="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY') }}">
                        </div>
                        <div class="form-group">
                            <label for="EDUCATION_LEVEL">What level? *</label>
                            <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL">
                                <option value="" disabled selected>Select level</option>
                                <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL') == 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL') == 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                <option value="Masters Degree" {{ old('EDUCATION_LEVEL') == 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                <option value="PhD" {{ old('EDUCATION_LEVEL') == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>
                    </div>
                    <p>Please send registration fee of KE.500 to M-Pesa Business No: 522533 Account No:7782321#mreg</p>
                    <div class="form-group">
                        <label for="REGISTRATION_FEE">Registration Fee (KES) *</label>
                        <input type="text" id="REGISTRATION_FEE" name="REGISTRATION_FEE" value="{{ old('REGISTRATION_FEE') }}">
                        @error('REGISTRATION_FEE')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Include JavaScript for dynamic form updates -->
    <script>
        document.querySelectorAll('input[name="CURRENTLY_IN_SCHOOL"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'Yes') {
                    document.getElementById('school_info').style.display = 'block';
                    document.getElementById('non_school_info').style.display = 'none';
                } else {
                    document.getElementById('school_info').style.display = 'none';
                    document.getElementById('non_school_info').style.display = 'block';
                }
            });
        });

        document.querySelectorAll('input[name="DISABILITY_STATUS"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'Yes') {
                    document.getElementById('disability_type').style.display = 'block';
                } else {
                    document.getElementById('disability_type').style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
