<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        background-color: #ffffff;
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
    }
    /* membership style cards */
    .card-hover {
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .gradient-individual {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        color: white;
    }

    .gradient-associate {
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
        color: white;
    }

    .card-hover h5,
    .card-hover p {
        margin: 0;
    }

    .card-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    @media (max-width: 768px) {
        .card-hover {
        padding: 0rem;
        font-size: 0.8rem;
        width: 250px;
    }
    .card-body {
        padding: 1rem;
    }

    .card-title {
        font-size: 13px;
    }

    .card-text {
        font-size: 13px;
    }

    .card-icon {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
}
    #participationSection {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    #participationSection label {
        margin-right: 10px; /* Adjust space between labels and inputs */
    }

    #participationSection input[type="radio"] {
        margin-right: 15px; /* Adjust space between radio buttons */
    }

     /* MODERN DESIGN CSS */
       /* Entire split layout */
.split-container {
    display: flex;
    min-height: 100vh;
}

/* Left Image Section */
.left-image {
    flex: 1;
    background: url('{{ asset('pictures/10.jpg') }}') no-repeat center center;
    background-size: cover;
}

/* Right Form Section */
.right-register {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    margin-top: 60px;
    background-color: #f4f4f4;
    padding: 40px 20px;

    /* Enable scrolling when content exceeds container */
    overflow: auto;
    max-height: 100vh;  /* Prevent it from growing beyond the viewport height */
}

    .register-container {
        max-width: 100%;
        margin-top: 10px;
    }


/* Hide left image on small and medium screens */
@media (max-width: 991.98px) {
    .left-image {
        display: none;
    }

    .split-container {
        flex-direction: column;
    }

    .right-register {
        flex: none;
        padding: 20px;
    }

    .register-container {
        max-width: 100%;
        margin-top: 100px;
    }
}

</style>
<!-- Bootstrap CSS (v4 or v5 depending on what you're using) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


 <!-- Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!--  CSS -->
    <style>
        * {
            font-family: 'Poppins';
        }
    </style>
        @yield('styles')
</head>

<body>
    <!-- Include the top navigation bar -->
    @include('dashboard.topnav')

    <div class="split-container">
    <div class="left-image"></div>

    <div class="right-register">
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
            <!-- <div class="logo-container"> -->
                <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" class="logo img-fluid">
            <!-- </div> -->
            <h2 style="color:rgb(61, 15, 81);">Membership Registration</h2>
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
        
             <!-- Primary Membership Selection -->
                <div id="membershipSelection" class="row justify-content-center mb-4 animate__animated animate__fadeInUp">
                    <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                        <label for="mainMembershipType" class="form-label fw-bold">Select Membership Type</label>
                        <select class="form-select" id="mainMembershipType" onchange="handleMainSelection(this.value)" style="width: 300px;">
                            <option value="">-- Choose a Membership Type --</option>
                            <option value="individual">Individual Membership</option>
                            <option value="organization">Organization Membership</option>
                        </select>
                    </div>
                </div>

                <!-- Sub-options for Individual Membership -->
                <div id="individualSubOptions" class="row justify-content-center mb-4 animate__animated animate__fadeInUp" style="display: none;">
                    <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                        <label for="individualMembershipType" class="form-label fw-bold">Which membership grade are you aaplying for?</label>
                        <select class="form-select" id="individualMembershipType" onchange="showForm(this.value)" style="width: 300px;">
                            <option value="">-- Choose Sub-type --</option>
                            <option value="student">Student Membership</option>
                            <option value="associate">Associate Membership</option>
                            <option value="full">Full Membership</option>
                        </select>
                    </div>
                </div>

                <!-- Title -->
                <h3 id="selectedMembershipTitle" style="text-align: center; display: none; color: brown; margin-bottom: 20px;"></h3>

                <!-- Participation Section -->
                <div id="participationSection" style="display: none;" class="form-row justify-content-center">
                    <div class="col-12 col-md-6">
                        <label class="fw-bold">Are you willing to participate in this registration?</label>
                        <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                            <div>
                                <label for="participation_yes">Yes</label>
                                <input type="radio" id="participation_yes" name="participation" value="Yes" onclick="toggleRegistrationForm(true)">
                            </div>
                            <div>
                                <label for="participation_no">No</label>
                                <input type="radio" id="participation_no" name="participation" value="No" onclick="toggleRegistrationForm(false)">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Organization Membership Form -->
            <div id="organizationForm" class="row justify-content-center mt-4 animate__animated animate__fadeInUp" style="display: none;">
                <div class="col-10 col-sm-8 col-md-6 col-lg-5">
                    <h4 class="text-center mb-3">Organization Membership Form</h4>
                    <form>
                        <div class="mb-3">
                            <label for="orgName" class="form-label">Organization Name</label>
                            <input type="text" class="form-control" id="orgName" name="orgName">
                        </div>
                        <div class="mb-3">
                            <label for="orgEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="orgEmail" name="orgEmail">
                        </div>
                        <div class="mb-3">
                            <label for="orgPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="orgPhone" name="orgPhone">
                        </div>
                        <div class="mb-3">
                            <label for="orgAddress" class="form-label">Physical Address</label>
                            <textarea class="form-control" id="orgAddress" name="orgAddress" rows="3"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
            function handleMainSelection(value) {
                const subOptions = document.getElementById('individualSubOptions');
                const orgForm = document.getElementById('organizationForm');
                const title = document.getElementById('selectedMembershipTitle');
                const participation = document.getElementById('participationSection');

                // Reset all
                subOptions.style.display = 'none';
                orgForm.style.display = 'none';
                participation.style.display = 'none';
                title.style.display = 'none';

                // Clear radio buttons
                document.getElementById('participation_yes').checked = false;
                document.getElementById('participation_no').checked = false;

                if (value === 'individual') {
                    subOptions.style.display = 'block';
                } else if (value === 'organization') {
                    title.innerText = 'Organization Membership';
                    title.style.display = 'block';
                    participation.style.display = 'block';
                }
            }

            function showForm(value) {
                const title = document.getElementById('selectedMembershipTitle');
                const participation = document.getElementById('participationSection');
                
                if (value === 'full') {
                    title.innerText = 'Full Membership';
                    title.style.display = 'block';
                } else if (value === 'associate') {
                    title.innerText = 'Associate Membership';
                    title.style.display = 'block';
                } 
                else if (value === 'student') {
                    title.innerText = 'Student Membership';
                    title.style.display = 'block';
                }
                else {
                    title.style.display = 'none';
                }

                participation.style.display = value ? 'block' : 'none';

                // Clear radio buttons
                document.getElementById('participation_yes').checked = false;
                document.getElementById('participation_no').checked = false;
            }

            function handleParticipationSelection(isYes) {
                const mainType = document.getElementById('mainMembershipType').value;
                const orgForm = document.getElementById('organizationForm');

                if (mainType === 'organization') {
                    orgForm.style.display = isYes ? 'block' : 'none';
                }

                // Optional: Add logic here if you have an individual form
            }
            </script>

            <!-- full registration form -->
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
             <div id="registrationForm" style="display: none;">
             @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were some problems with your input: check all your inputs before submitting</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             <div id="form-full" class="membership-form" style="display: none;">
                      <h1 style="color: maroon; font-size: 20px;  text-align:center;">Full Membership</h1>
                <!-- Display errors if any -->
             <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="TITTLE" class="required-label">Title</label>
                    <select name="TITTLE" id="TITTLE" class="form-control" required style="height: auto;">
                        <option value="">-select title-</option>
                        <option value="Mr." {{ old('TITTLE') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Mrs." {{ old('TITTLE') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms." {{ old('TITTLE') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                        <option value="Dr." {{ old('TITTLE') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        <option value="Prof." {{ old('TITTLE') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="FIRST_NAME" class="required-label">Name (As you would like it to appear on the Certificate) </label>
                    <input type="text" name="FIRST_NAME" id="FIRST_NAME" class="form-control" value="{{ old('FIRST_NAME') }}" required>
                    @error('FIRST_NAME')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label for="GENDER" class="required-label">Gender </label>
                    <select name="GENDER" id="GENDER" class="form-control" required style="height: auto;">
                        <option value="">-- Select --</option>
                        <option value="Male" {{ old('GENDER') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('GENDER') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('GENDER')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

              <!-- row-->
              <div class="form-row">
                      <!-- Email -->
                      <div class="form-group">
                        <label for="EMAIL" class="required-label">Email </label>
                        <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" required>
                        @error('EMAIL')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="NATIONAL_ID_NUMBER" class="required-label">National ID Number </label>
                        <input type="text" id="NATIONAL_ID_NUMBER" name="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER') }}" required>
                        @error('NATIONAL_ID_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--   Row -->
                <div class="form-row">

                    <div class="form-group">
                        <label for="PHONE_NUMBER" class="required-label">Phone Number </label>
                        <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER') }}" required>
                        @error('PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
              <!-- Disability related question -->
                <div class="form-group">
                    <label for="DISABILITY_STATUS" class="required-label">Do you have any form of disability? </label>
                    <label for="DISABILITY_YES">Yes</label>
                    <input type="radio" id="DISABILITY_YES" name="DISABILITY_STATUS" value="Yes" {{ old('DISABILITY_STATUS') == 'Yes' ? 'checked' : '' }}>
                    <label for="DISABILITY_NO">No</label>
                    <input type="radio" id="DISABILITY_NO" name="DISABILITY_STATUS" value="No" {{ old('DISABILITY_STATUS') == 'No' ? 'checked' : '' }}>
                </div>

                <!-- Disability type -->
                <div id="disability_type" style="display: {{ old('DISABILITY_STATUS') == 'Yes' ? 'block' : 'none' }}">
                    <div class="form-group">
                        <label for="DISABILITY_TYPE">Type of Disability </label>
                        <input type="text" id="DISABILITY_TYPE" name="DISABILITY_TYPE" value="{{ old('DISABILITY_TYPE') }}">
                    </div>
                </div>
               
                </div>
                <div class="form-row">
                        <div class="form-group">
                            <label>Postal Address</label>
                            <input type="text" name="POSTAL_ADDRESS" class="form-control" value="{{ old('POSTAL_ADDRESS') }}">
                        </div>

                        <div class="form-group">
                            <label>Physical Address</label>
                            <input type="text" name="PHYSICAL_ADDRESS" class="form-control" value="{{ old('PHYSICAL_ADDRESS') }}">
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>County of Residence ( For Kenyans)</label>
                            <input type="text" name="COUNTY" class="form-control" value="{{ old('COUNTY') }}">
                        </div>

                        <div class="form-group">
                            <label>LinkedIn Profile</label>
                            <input type="text" name="LINKEDIN" class="form-control" value="{{ old('LINKEDIN') }}">
                        </div>
                    </div>

                                    <!-- School related fields for users not currently in school -->
                                    <div class="form-row">
                    <div class="form-group">
                            <label for="EDUCATION_LEVEL"  class="required-label">Highest Level of Education </label>
                            <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" required>
                                <option value="" disabled selected>Select level</option>
                                <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL') == 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL') == 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                <option value="Masters Degree" {{ old('EDUCATION_LEVEL') == 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                <option value="PhD" {{ old('EDUCATION_LEVEL') == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="PREVIOUS_PROGRAM_OF_STUDY"  class="required-label">Program of Study </label>
                        <input type="text" id="PREVIOUS_PROGRAM_OF_STUDY" name="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY') }}" required>
                    </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label  class="required-label">Current Profession </label>
                            <input type="text" name="PROFESSION" class="form-control" value="{{ old('PROFESSION') }}" required>
                        </div>

                        <div class="form-group">
                            <label  class="required-label">Current Place of Work</label>
                            <input type="text" name="WORK_PLACE" class="form-control" value="{{ old('WORK_PLACE') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label  class="required-label">Job Title</label>
                            <input type="text" name="JOB" class="form-control" value="{{ old('JOB') }}" required>
                        </div>
                        <div class="form-group">
                            <label  class="required-label">Date</label>
                            <input type="date" name="DATE" class="form-control" value="{{ old('DATE') }}" required>
                        </div>
                    </div>
                        <!-- Passport photo -->
                        <div class="form-group">
                                <label for="PASSPORT_PHOTO"  class="required-label">
                                Upload a Passport-Sized Photo for Your Membership Smart Card (Not a Selfie)  </label> <p style="color: maroon;">Images should be in format: jpeg, png, jpg</p>
                                <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" accept=".jpeg,.png,.jpg" required>
                        </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Any Comment (optional)</label>
                            <textarea name="COMMENT" class="form-control">{{ old('COMMENT') }}</textarea>
                        </div>
                </div>
                <input type="hidden" name="type" value="full">
                <!-- must_change_password to ensure when user logs in change password form is displayed -->
                <input type="hidden" name="must_change_password" value="1">
                <!-- declaration -->
                    <div class="form-check mt-4 mb-4">
                        <input class="form-check-input" type="checkbox" id="declaration" name="declaration" required>
                        <label class="form-check-label" for="declaration">
                            <span style="color: red; font-weight: bold">*</span>
                            I declare that the information given herein is correct to the best of my knowledge and belief, and, if approved, I agree to be bound by the Constitution of the Association as it now exists and as may hereafter be amended from time to time.
                        </label>
                    </div>
          <p style="color: maroon; font-size: 17px;"><strong>Please send registration fee of KE.1000 to M-Pesa Business No: 522533 Account No:7782321#mreg</strong></p>
                <p>Go to the <strong>Lipa na MPESA</strong> menu and select <strong>Paybill</strong>.</p>
                <p><strong>Business Number</strong>: 522533</p>
                <p><strong>Account Number</strong>: Enter <code>7782321#me</code></p>
                <p>Enter the <strong>fare</strong>: KES 1000</p>
                <p>Enter your <strong>PIN number</strong>.</p>
                <p>Wait for the <strong>MPESA confirmation SMS</strong>.</p>
                <p>Fill in this form and <strong>submit below</strong>.</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ALTERNATIVE_PHONE_NUMBER" class="required-label">
                            Cell Phone Number 
                            <l style="color: maroon; font-size: 10px;">(The Number used for M-Pesa Payment)</l>
                        </label>
                        <input type="text" id="ALTERNATIVE_PHONE_NUMBER" name="ALTERNATIVE_PHONE_NUMBER"
                            value="{{ old('ALTERNATIVE_PHONE_NUMBER') }}" required>
                        @error('ALTERNATIVE_PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="REGISTRATION_FEE" class="required-label">M-Pesa Transaction ID (e.g TE69MHLK8Q) *</label>
                        <input type="text" id="REGISTRATION_FEE" name="REGISTRATION_FEE"
                            value="{{ old('REGISTRATION_FEE') }}" required>
                        @error('REGISTRATION_FEE')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                    <button type="submit">Create Account</button>
                </div>
                </form>


                <!-- OTHER MEMBERSHIP FORMS -->
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="form-student" class="membership-form" style="display: none;">
                    <h1 style="color: maroon; font-size: 20px;  text-align:center;">Student Membership</h1>
                    <!-- Your Student Membership form here -->
                    <!-- Display errors if any -->
                     <!-- Title -->
             <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="TITTLE" class="required-label">Title</label>
                    <select name="TITTLE" id="TITTLE" class="form-control" required style="height: auto;">
                        <option value="">-select title-</option>
                        <option value="Mr." {{ old('TITTLE') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Mrs." {{ old('TITTLE') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms." {{ old('TITTLE') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                        <option value="Dr." {{ old('TITTLE') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        <option value="Prof." {{ old('TITTLE') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                    </select>
                </div>
             </div>
             <!-- Name -->
              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="FIRST_NAME" class="required-label">Name  </label>
                    <input type="text" name="FIRST_NAME" id="FIRST_NAME" class="form-control" placeholder="As you would like it to appear on the Certificate" value="{{ old('FIRST_NAME') }}" required>
                    @error('FIRST_NAME')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

          <!-- Gender and Email -->
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="GENDER" class="required-label">Gender </label>
                    <select name="GENDER" id="GENDER" class="form-control" required style="height: auto;">
                        <option value="">-- Select --</option>
                        <option value="Male" {{ old('GENDER') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('GENDER') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('GENDER')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                      <!-- Email -->
                      <div class="form-group">
                        <label for="EMAIL" class="required-label">Email </label>
                        <input type="email" id="EMAIL" name="EMAIL" placeholder="Enter valid email address" value="{{ old('EMAIL') }}" required>
                        @error('EMAIL')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
            </div>
            <!-- ID NUMBER -->
              <div class="form-row">
                    <div class="form-group">
                        <label for="NATIONAL_ID_NUMBER" class="required-label">National ID Number </label>
                        <input type="text" id="NATIONAL_ID_NUMBER" name="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER') }}" required>
                        @error('NATIONAL_ID_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--   Row -->
                   <!-- phone number -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="PHONE_NUMBER" class="required-label">Phone Number </label>
                        <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER') }}" required>
                        @error('PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                                  <!-- Disability related question -->
            <div class="form-row">
                <div class="form-group">
                    <label for="DISABILITY_STATUS" class="required-label">Do you have any form of disability? </label><br>

                    <label for="DISABILITY_YES">Yes</label>
                    <input type="radio" id="DISABILITY_YES" name="DISABILITY_STATUS" value="Yes"
                        {{ old('DISABILITY_STATUS') == 'Yes' ? 'checked' : '' }} onclick="toggleDisabilityTypeField(true)">

                    <label for="DISABILITY_NO">No</label>
                    <input type="radio" id="DISABILITY_NO" name="DISABILITY_STATUS" value="No"
                        {{ old('DISABILITY_STATUS') == 'No' ? 'checked' : '' }} onclick="toggleDisabilityTypeField(false)">
                </div>
            </div>

                <!-- Disability type -->
                <div id="disability_type_field" style="display: {{ old('DISABILITY_STATUS') == 'Yes' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label for="DISABILITY_TYPE" >Type of Disability </label>
                        <input type="text" id="DISABILITY_TYPE" name="DISABILITY_TYPE" value="{{ old('DISABILITY_TYPE') }}">
                    </div>
                </div>

                <!-- Inline Script (Scoped to this section) -->
                <script>
                    function toggleDisabilityTypeField(show) {
                        document.getElementById('disability_type_field').style.display = show ? 'block' : 'none';
                    }

                    window.addEventListener('DOMContentLoaded', function () {
                        toggleDisabilityTypeField(document.getElementById('DISABILITY_YES').checked);
                    });
                </script>
                

                <div class="form-row">
                        <div class="form-group">
                            <label>Postal Address</label>
                            <input type="text" name="POSTAL_ADDRESS" class="form-control" value="{{ old('POSTAL_ADDRESS') }}">
                        </div>

                        <div class="form-group">
                            <label>Physical Address</label>
                            <input type="text" name="PHYSICAL_ADDRESS" class="form-control" value="{{ old('PHYSICAL_ADDRESS') }}">
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>County of Residence ( For Kenyans)</label>
                            <input type="text" name="COUNTY" class="form-control" value="{{ old('COUNTY') }}">
                        </div>

                        <div class="form-group">
                            <label>LinkedIn Profile</label>
                            <input type="text" name="LINKEDIN" class="form-control" value="{{ old('LINKEDIN') }}">
                        </div>
                    </div>

                    <!-- School related fields for users not currently in school -->
                    <div class="form-row">
                         <div class="form-group">
                            <label for="SCHOOL_NAME" class="required-label">Name of School</label>
                            <input type="text" id="SCHOOL_NAME" name="SCHOOL_NAME" value="{{ old('SCHOOL_NAME') }}" required>
                        </div>
                    <div class="form-group">
                            <label for="EDUCATION_LEVEL" class="required-label">Current Highest Level of Education </label>
                            <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" required>
                                <option value="" disabled selected>Select level</option>
                                <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL') == 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL') == 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                <option value="Masters Degree" {{ old('EDUCATION_LEVEL') == 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                <option value="PhD" {{ old('EDUCATION_LEVEL') == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                    </div>
                       
                   </div>

                    <div class="form-row">
                         <div class="form-group">
                        <label for="SCHOOL_REGISTRATION_NUMBER" class="required-label">Current Year of Study</label>
                        <select id="SCHOOL_REGISTRATION_NUMBER" name="SCHOOL_REGISTRATION_NUMBER" class="form-control" required style="height: auto;">
                            <option value="">-- Select Year --</option>
                            <option value="1" {{ old('SCHOOL_REGISTRATION_NUMBER') == '1' ? 'selected' : '' }}>Year 1</option>
                            <option value="2" {{ old('SCHOOL_REGISTRATION_NUMBER') == '2' ? 'selected' : '' }}>Year 2</option>
                            <option value="3" {{ old('SCHOOL_REGISTRATION_NUMBER') == '3' ? 'selected' : '' }}>Year 3</option>
                            <option value="4" {{ old('SCHOOL_REGISTRATION_NUMBER') == '4' ? 'selected' : '' }}>Year 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="PREVIOUS_SCHOOL_NAME" class="required-label">Current Semester of Study</label>
                        <select id="PREVIOUS_SCHOOL_NAME" name="PREVIOUS_SCHOOL_NAME" class="form-control" required style="height: auto; width:auto;">
                            <option value="">-- Select Semester --</option>
                            <option value="1" {{ old('PREVIOUS_SCHOOL_NAME') == '1' ? 'selected' : '' }}>semester 1</option>
                            <option value="2" {{ old('PREVIOUS_SCHOOL_NAME') == '2' ? 'selected' : '' }}>semester 2</option>
                        </select>
                    </div>
                </div>

                    <div class="form-row">
                    <div class="form-group">
                        <label for="PREVIOUS_PROGRAM_OF_STUDY" class="required-label">Program of Study </label>
                        <input type="text" id="PREVIOUS_PROGRAM_OF_STUDY" name="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY') }}" required>
                    </div>
                        <div class="form-group">
                            <label class="required-label">Date</label>
                            <input type="date" name="DATE" class="form-control" value="{{ old('DATE') }}" required>
                        </div>
                    </div>
                        <!-- Passport photo -->
                        <div class="form-group">
                                <label for="PASSPORT_PHOTO" class="required-label">
                                Upload a Passport-Sized Photo for Your Membership Smart Card (Not a Selfie)  </label> <p style="color: maroon;">Images should be in format: jpeg, png, jpg</p>
                                <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" accept=".jpeg,.png,.jpg" required>
                        </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label> Any Comment (optional)</label>
                            <textarea name="COMMENT" class="form-control">{{ old('COMMENT') }}</textarea>
                        </div>
                </div>
                <input type="hidden" name="type" value="student">
                <!-- must_change_password to ensure when user logs in change password form is displayed -->
                <input type="hidden" name="must_change_password" value="1">
                                <!-- declaration -->
                    <div class="form-check mt-4 mb-4">
                        <input class="form-check-input" type="checkbox" id="declaration" name="declaration" required>
                        <label class="form-check-label" for="declaration">
                            <span style="color: red; font-weight: bold">*</span>
                            I declare that the information given herein is correct to the best of my knowledge and belief, and, if approved, I agree to be bound by the Constitution of the Association as it now exists and as may hereafter be amended from time to time.
                        </label>
                    </div>

                      <!-- MPESA Instructions -->
                    <!-- M-Pesa Summary + Button -->
                    <div style="margin: 25px 0; background-color: #fff7f7; padding: 15px; border-left: 5px solid maroon; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div style="flex-grow: 1;">
                            <p style="margin: 5px 0;"><strong>Pay KES 300 via M-Pesa:</strong></p>
                            <p style="margin: 5px 0;">Paybill: <strong>522533</strong></p>
                            <p style="margin: 5px 0;">Account No: <strong>7782321#me</strong></p>
                            <p style="margin: 5px 0;">Wait for the <strong>MPESA confirmation SMS</strong>.</p>
                            <p style="margin: 5px 0;">Fill in this form below and <strong>submit</strong>.</p>
                        </div>

                        <!-- Payment Instructions Button -->
                        <div>
                            <button onclick="openModal()" style="background-color: maroon; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                Full Instructions
                            </button>
                        </div>
                    </div>

                    <!-- Modal Popup -->
                    <div id="paymentModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6);">
                        <div style="background-color: #fff; margin: 10% auto; padding: 30px; border-radius: 10px; width: 90%; max-width: 600px; position: relative;">
                            <!-- Close Button -->
                            <span onclick="closeModal()" style="position: absolute; top: 10px; right: 20px; font-size: 22px; font-weight: bold; color: maroon; cursor: pointer;">&times;</span>

                            <h3 style="color: green; text-align: center; margin-bottom: 15px;">Payment Instructions</h3>
                            <p style="color: green; font-size: 17px;"><strong>Please send registration fee of KES 300 to M-Pesa Business No: 522533 Account No: 7782321#me</strong></p>
                            <p>1. Go to the <strong>Lipa na MPESA</strong> menu and select <strong>Paybill</strong>.</p>
                            <p>2. <strong>Business Number</strong>: 522533</p>
                            <p>3. <strong>Account Number</strong>: Enter <code>7782321#me</code></p>
                            <p>4. Enter the <strong>Amount</strong>: KES 300</p>
                            <p>5. Enter your <strong>PIN number</strong>.</p>
                            <p>6. Wait for the <strong>MPESA confirmation SMS</strong>.</p>
                            <p>7. Fill in this form below and <strong>submit </strong>.</p>
                        </div>
                    </div>

                    <!-- Modal Script -->
                    <script>
                        function openModal() {
                            document.getElementById('paymentModal').style.display = 'block';
                        }

                        function closeModal() {
                            document.getElementById('paymentModal').style.display = 'none';
                        }

                        // Optional: Close modal if user clicks outside the box
                        window.onclick = function(event) {
                            const modal = document.getElementById('paymentModal');
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        }
                    </script>

        <!-- Transaction ID -->
                <div style="margin-bottom: 15px;">
                    <label for="REGISTRATION_FEE" style="font-weight: bold;">M-Pesa Transaction Code <span style="color:red">*</span></label>
                    <input type="text" name="REGISTRATION_FEE" id="REGISTRATION_FEE" placeholder="e.g. TE69MHLK8Q" value="{{ old('REGISTRATION_FEE') }}" required
                        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                </div>

                <!-- M-Pesa Phone Number -->
                <div style="margin-bottom: 15px;">
                    <label for="ALTERNATIVE_PHONE_NUMBER" style="font-weight: bold;">M-Pesa Phone Number <span style="color:red">*</span></label>
                    <input type="text" name="ALTERNATIVE_PHONE_NUMBER" id="ALTERNATIVE_PHONE_NUMBER" placeholder="Phone number used to pay" value="{{ old('ALTERNATIVE_PHONE_NUMBER') }}" required
                        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                </div>

                    <button type="submit" style="margin-bottom: 5px;">Create Account</button>
                </div>
                </form>

                <!-- ASSOCIATE MEMBERSHIP -->
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="form-associate" class="membership-form" style="display: none;">
                    <h1 style="color: maroon; font-size: 20px;  text-align:center;">Associate Membership</h1>
                    <!-- Your Associate Membership form here -->
                    <!-- Display errors if any -->
             <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="TITTLE" class="required-label">Title</label>
                    <select name="TITTLE" id="TITTLE" class="form-control" required style="height: auto;">
                        <option value="">-select title-</option>
                        <option value="Mr." {{ old('TITTLE') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Mrs." {{ old('TITTLE') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms." {{ old('TITTLE') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                        <option value="Dr." {{ old('TITTLE') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        <option value="Prof." {{ old('TITTLE') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="FIRST_NAME" class="required-label">Name (As you would like it to appear on the Certificate) </label>
                    <input type="text" name="FIRST_NAME" id="FIRST_NAME" class="form-control" value="{{ old('FIRST_NAME') }}" required>
                    @error('FIRST_NAME')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label for="GENDER" class="required-label">Gender </label>
                    <select name="GENDER" id="GENDER" class="form-control" required style="height: auto;">
                        <option value="">-- Select --</option>
                        <option value="Male" {{ old('GENDER') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('GENDER') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('GENDER')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

              <!-- row-->
              <div class="form-row">
                      <!-- Email -->
                      <div class="form-group">
                        <label for="EMAIL" class="required-label">Email </label>
                        <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" required>
                        @error('EMAIL')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="NATIONAL_ID_NUMBER" class="required-label">National ID Number </label>
                        <input type="text" id="NATIONAL_ID_NUMBER" name="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER') }}" required>
                        @error('NATIONAL_ID_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--   Row -->
                <div class="form-row">

                    <div class="form-group">
                        <label for="PHONE_NUMBER" class="required-label">Phone Number </label>
                        <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER') }}" required>
                        @error('PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                                  <!-- Disability related question -->
                <div class="form-group">
                    <label for="DISABILITY_STATUS" class="required-label">Do you have any form of disability? </label><br>

                    <label for="DISABILITY_YES">Yes</label>
                    <input type="radio" id="DISABILITY_YES" name="DISABILITY_STATUS" value="Yes"
                        {{ old('DISABILITY_STATUS') == 'Yes' ? 'checked' : '' }} onclick="toggleDisabilityTypeField(true)">

                    <label for="DISABILITY_NO">No</label>
                    <input type="radio" id="DISABILITY_NO" name="DISABILITY_STATUS" value="No"
                        {{ old('DISABILITY_STATUS') == 'No' ? 'checked' : '' }} onclick="toggleDisabilityTypeField(false)">
                </div>

                <!-- Disability type -->
                <div id="disability_type_field" style="display: {{ old('DISABILITY_STATUS') == 'Yes' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label for="DISABILITY_TYPE" >Type of Disability </label>
                        <input type="text" id="DISABILITY_TYPE" name="DISABILITY_TYPE" value="{{ old('DISABILITY_TYPE') }}">
                    </div>
                </div>

                <!-- Inline Script (Scoped to this section) -->
                <script>
                    function toggleDisabilityTypeField(show) {
                        document.getElementById('disability_type_field').style.display = show ? 'block' : 'none';
                    }

                    window.addEventListener('DOMContentLoaded', function () {
                        toggleDisabilityTypeField(document.getElementById('DISABILITY_YES').checked);
                    });
                </script>
                </div>

                <div class="form-row">
                        <div class="form-group">
                            <label>Postal Address</label>
                            <input type="text" name="POSTAL_ADDRESS" class="form-control" value="{{ old('POSTAL_ADDRESS') }}">
                        </div>

                        <div class="form-group">
                            <label>Physical Address</label>
                            <input type="text" name="PHYSICAL_ADDRESS" class="form-control" value="{{ old('PHYSICAL_ADDRESS') }}">
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>County of Residence ( For Kenyans)</label>
                            <input type="text" name="COUNTY" class="form-control" value="{{ old('COUNTY') }}">
                        </div>

                        <div class="form-group">
                            <label>LinkedIn Profile</label>
                            <input type="text" name="LINKEDIN" class="form-control" value="{{ old('LINKEDIN') }}">
                        </div>
                    </div>

                                    <!-- School related fields for users not currently in school -->
                                    <div class="form-row">
                    <div class="form-group">
                            <label for="EDUCATION_LEVEL" class="required-label">Highest Level of Education </label>
                            <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" required>
                                <option value="" disabled selected>Select level</option>
                                <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL') == 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL') == 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                <option value="Masters Degree" {{ old('EDUCATION_LEVEL') == 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                <option value="PhD" {{ old('EDUCATION_LEVEL') == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="PREVIOUS_PROGRAM_OF_STUDY" class="required-label">Program of Study </label>
                        <input type="text" id="PREVIOUS_PROGRAM_OF_STUDY" name="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY') }}" required>
                    </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="required-label">Current Profession </label>
                            <input type="text" name="PROFESSION" class="form-control" value="{{ old('PROFESSION') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="required-label">Current Place of Work</label>
                            <input type="text" name="WORK_PLACE" class="form-control" value="{{ old('WORK_PLACE') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="required-label">Job Title</label>
                            <input type="text" name="JOB" class="form-control" value="{{ old('JOB') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="required-label">Date</label>
                            <input type="date" name="DATE" class="form-control" value="{{ old('DATE') }}" required>
                        </div>
                    </div>
                        <!-- Passport photo -->
                        <div class="form-group">
                                <label for="PASSPORT_PHOTO" class="required-label">
                                Upload a Passport-Sized Photo for Your Membership Smart Card (Not a Selfie)  </label> <p style="color: maroon;">Images should be in format: jpeg, png, jpg</p>
                                <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" accept=".jpeg,.png,.jpg" required>
                        </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Any Comment (optional)</label>
                            <textarea name="COMMENT" class="form-control">{{ old('COMMENT') }}</textarea>
                        </div>
                </div>
                <input type="hidden" name="type" value="associate">
                <!-- must_change_password to ensure when user logs in change password form is displayed -->
                <input type="hidden" name="must_change_password" value="1">
                    <!-- declaration -->
                    <div class="form-check mt-4 mb-4">
                        <input class="form-check-input" type="checkbox" id="declaration" name="declaration" required>
                        <label class="form-check-label" for="declaration">
                            <span style="color: red; font-weight: bold">*</span>
                            I declare that the information given herein is correct to the best of my knowledge and belief, and, if approved, I agree to be bound by the Constitution of the Association as it now exists and as may hereafter be amended from time to time.
                        </label>
                    </div>
                <p style="color: maroon; font-size: 17px;"><strong>Please send registration fee of KE.500 to M-Pesa Business No: 522533 Account No:7782321#mreg</strong></p>
                <p>Go to the <strong>Lipa na MPESA</strong> menu and select <strong>Paybill</strong>.</p>
                <p><strong>Business Number</strong>: 522533</p>
                <p><strong>Account Number</strong>: Enter <code>7782321#me</code></p>
                <p>Enter the <strong>fare</strong>: KES 500</p>
                <p>Enter your <strong>PIN number</strong>.</p>
                <p>Wait for the <strong>MPESA confirmation SMS</strong>.</p>
                <p>Fill in this form and <strong>submit below</strong>.</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ALTERNATIVE_PHONE_NUMBER" class="required-label">
                            Cell Phone Number 
                            <l style="color: maroon; font-size: 10px;">(The Number used for M-Pesa Payment)</l>
                        </label>
                        <input type="text" id="ALTERNATIVE_PHONE_NUMBER" name="ALTERNATIVE_PHONE_NUMBER"
                            value="{{ old('ALTERNATIVE_PHONE_NUMBER') }}" required>
                        @error('ALTERNATIVE_PHONE_NUMBER')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="REGISTRATION_FEE" class="required-label">M-Pesa Transaction ID (e.g TE69MHLK8Q) *</label>
                        <input type="text" id="REGISTRATION_FEE" name="REGISTRATION_FEE"
                            value="{{ old('REGISTRATION_FEE') }}" required>
                        @error('REGISTRATION_FEE')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                    <button type="submit">Create Account</button>
                </div>
                </form>

                    <div id="organizationForm" class="membership-form" style="display: none;">
                        <!-- Your Organization/Association Membership form here -->
                        <p class="text-center text-muted" style="background-color: #00c6ff; color: #f4f4f4;">Organization Membership Form will be updated soon</p>
                    </div>
             </div>
            </div>
         </div>
        </form>
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
<!-- MEMBERSHIPS SCRIPTS -->
<script>
    let selectedMembership = '';

    function showForm(value) {
        selectedMembership = value;

        // Hide all forms first
        document.querySelectorAll('.membership-form').forEach(form => {
            form.style.display = 'none';
        });

        // Show participation question
        document.getElementById('participationSection').style.display = value ? 'block' : 'none';

        // Hide registration form until user answers Yes
        document.getElementById('registrationForm').style.display = 'none';

        // Hide the form title
        document.getElementById('selectedMembershipTitle').style.display = 'none';

        // Clear any selected participation
        document.getElementsByName('participation').forEach(r => r.checked = false);
    }

    function toggleRegistrationForm(show) {
        if (show && selectedMembership) {
            document.getElementById('registrationForm').style.display = 'block';

            // Show only the relevant form
            document.querySelectorAll('.membership-form').forEach(form => {
                form.style.display = 'none';
            });

            const formId = `form-${selectedMembership}`;
            const formElement = document.getElementById(formId);

            if (formElement) {
                formElement.style.display = 'block';

                // Update title
                const titleMap = {
                    individual: 'Individual Membership',
                    associate: '',
                    full: '',
                    organization: 'Organization Membership'
                };

                document.getElementById('selectedMembershipTitle').innerText = titleMap[selectedMembership] || '';
                document.getElementById('selectedMembershipTitle').style.display = 'block';
            }
        } else {
            document.getElementById('registrationForm').style.display = 'none';
            document.getElementById('selectedMembershipTitle').style.display = 'none';
        }
    }
</script>
<!-- include code for declaration check box to function -->
 <!-- Before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<style>
    .required-label::after {
    content: " *";
    color: red;
    font-weight: bold;
}

.logo {
    width: 150px;
    max-width: 100%;
    height: auto;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

/* Medium screens and below */
@media (max-width: 768px) {
    .logo {
        width: 100px;
    }
}

/* Small screens */
@media (max-width: 480px) {
    .logo {
        width: 100px;
    }
}

/* Ensure full width on small screens */
@media (max-width: 767.98px) {
    .form-group {
        width: 100% !important;
        margin-bottom: 1rem;
    }

    .form-row,
    .row {
        display: flex;
        flex-direction: column;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
    }
}

/* For medium devices: stack only if necessary */
@media (min-width: 768px) and (max-width: 991.98px) {
    .form-group {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }

    .form-row,
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .form-group.half-width {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
}


</style>