@extends('layouts.app')

@section('content')

<section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{ asset($user->PASSPORT_PHOTO) }}" alt="Profile" class="rounded-circle">
              <h2>{{ $user->FIRST_NAME }} {{ $user->LAST_NAME }}</h2>
              <h3>{{ $user->role->name }}</h3>
              <p>
                  Membership Number: 
                  <span style="color:brown; font-weight: bold;">
                      @if(!$user->role) 
                          Pending Approval
                      @else
                          {{ $user->MEMBERSHIP_NUMBER }}
                      @endif
                  </span>
              </p>

              <!-- <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> -->
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li>

                <!-- <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li> -->

              </ul>

              <div class="tab-content pt-2">
                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                 <form method="POST" action="{{ route('user.theme.update') }}">
                    @csrf
                    <div class="row mb-3 ">
                        <label class="form-label fw-bold">Theme Mode</label>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="themeMode" id="lightMode" value="light" 
                                    {{ auth()->user()->theme_mode === 'light' ? 'checked' : '' }}>
                                <label class="form-check-label" for="lightMode">
                                    <i class="bi bi-brightness-high"></i> Light Mode
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="themeMode" id="darkMode" value="dark"
                                    {{ auth()->user()->theme_mode === 'dark' ? 'checked' : '' }}>
                                <label class="form-check-label" for="darkMode">
                                    <i class="bi bi-moon"></i> Dark Mode
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
     <!-- End settings Form -->
              </div>

        <!-- ADMIN PROFILE -->
           @if(auth()->user()->hasRole('admin'))
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <!-- <h5 class="card-title">About</h5>
                  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

                  <h5 class="card-title">Profile Details</h5>
                
                <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{ $user->TITTLE }}. {{ $user->FIRST_NAME }} {{ $user->MIDDLE_NAME }} {{ $user->LAST_NAME }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->EMAIL }}</div>
                  </div>

                 
                </div>
            </div>

      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
         <form action="{{ route('profile.update', $user->ID) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
                @csrf
                @method('PUT')
                  <div class="row mb-3">
                      <label for="PASSPORT_PHOTO" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="{{ asset($user->PASSPORT_PHOTO) }}" alt="Upload Profile">
                        <div class="pt-2">
                         <div class="form-group">
                              <label for="PASSPORT_PHOTO" class="form-label" style="font-weight: 600; color: #333;">
                                  <!-- Passport Photo <span class="text-danger">*</span> -->
                              </label>

                              <!-- Hidden File Input -->
                              <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" 
                                    accept=".jpeg,.png,.jpg" 
                                    class="d-none">

                              <!-- Styled Button as Upload Trigger -->
                              <label for="PASSPORT_PHOTO" class="btn btn-primary btn-sm" title="Upload new profile image" style="border-radius: 6px; color: white;">
                                  <i class="bi bi-upload"></i>
                              </label>

                              <!-- Show filename after selection -->
                              <span id="file-name" class="ms-2 text-muted" style="font-size: 14px;">No file chosen</span>
                          </div>

                          <script>
                              document.getElementById("PASSPORT_PHOTO").addEventListener("change", function() {
                                  const fileName = this.files[0] ? this.files[0].name : "No file chosen";
                                  document.getElementById("file-name").textContent = fileName;
                              });
                          </script>
                          <!-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                        </div>
                      </div>
                    </div>

                   <div class="row mb-3">
                    <!-- Tittle -->
                      <div class="col-md-4 mb-3">
                          <label for="TITTLE" class="form-label">Title</label>
                          <select name="TITTLE" id="TITTLE" class="form-select" required>
                              <option value="">-- Select Title --</option>
                              <option value="Mr."   {{ old('TITTLE', $user->TITTLE) === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                              <option value="Mrs."  {{ old('TITTLE', $user->TITTLE) === 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                              <option value="Ms."   {{ old('TITTLE', $user->TITTLE) === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                              <option value="Dr."   {{ old('TITTLE', $user->TITTLE) === 'Dr.' ? 'selected' : '' }}>Dr.</option>
                              <option value="Prof." {{ old('TITTLE', $user->TITTLE) === 'Prof.' ? 'selected' : '' }}>Prof.</option>
                          </select>
                      </div>
                        <!-- First Name -->
                      <div class="col-md-4">
                         <label for="FIRST_NAME" class="form-label">Name (as they appear on your Certificate)</label>
                            <input name="FIRST_NAME" type="text" class="form-control" 
                                  id="FIRST_NAME" value="{{ old('FIRST_NAME', $user->FIRST_NAME) }}"style= " background-color: #e9ecef;" readonly>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                           <label for="LAST_NAME" class="form-label">Last Name</label>
                            <input name="LAST_NAME" type="text" class="form-control" 
                                  id="LAST_NAME" value="{{ old('LAST_NAME', $user->LAST_NAME) }}"style= " background-color: #e9ecef;" readonly>
                        </div>

                         <!-- Middle name -->
                         <div class="col-md-6">
                            <label for="MIDDLE_NAME" class="form-label">Middle name</label>
                            <input name="MIDDLE_NAME" type="text" class="form-control" 
                                  id="MIDDLE_NAME" value="{{ old('MIDDLE_NAME', $user->MIDDLE_NAME) }}"style= " background-color: #e9ecef;" readonly>
                        </div>
                    </div>

                      <div class="row mb-3">
                        <!-- Email -->
                         <div class="col-md-6">
                          <label for="EMAIL" class="form-label">Email</label>
                            <input name="EMAIL" type="text" class="form-control" 
                                  id="EMAIL" value="{{ old('EMAIL', $user->EMAIL) }}" style= " background-color: #e9ecef;" readonly>
                        </div>

               <!-- hide fields -->
                <div class="col-md-6 d-none">
                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="GENDER" class="form-label">Gender</label>
                            <select id="GENDER" name="GENDER" class="form-select readonly-select">
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('GENDER', $user->GENDER) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('GENDER', $user->GENDER) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>


                    <div class="row mb-3">
               
                        <!-- National id number-->
                        <div class="col-md-6">
                         <label for="NATIONAL_ID_NUMBER" class="form-label">National id Number</label>
                            <input name="NATIONAL_ID_NUMBER" type="text" class="form-control" 
                                  id="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER', $user->NATIONAL_ID_NUMBER) }}" style= " background-color: #e9ecef;" readonly>
                        </div>
                        
                        <!-- 	PHONE_NUMBER  -->
                       <div class="col-md-6">
                          <label for="PHONE_NUMBER" class="form-label">Phone Number</label>
                            <input name="PHONE_NUMBER" type="text" class="form-control" 
                                  id="PHONE_NUMBER" value="{{ old('PHONE_NUMBER', $user->PHONE_NUMBER) }}">
                        </div>
                    

                     <div class="row mb-3">
                        <!-- Disability Status-->
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

                    <div class="row mb-3">
                        <!-- Postal Address-->
                        <div class="col-md-6">
                            <label for="POSTAL_ADDRESS" class="form-label">Postal Address</label>
                                <input name="POSTAL_ADDRESS" type="text" class="form-control" 
                                  id="POSTAL_ADDRESS" value="{{ old('POSTAL_ADDRESS', $user->POSTAL_ADDRESS) }}">
                        </div>

                        <!-- 	Pysical Address -->
                       <div class="col-md-6">
                        <label for="PHYSICAL_ADDRESS" class="form-label">Physical Address</label>
                            <input name="PHYSICAL_ADDRESS" type="text" class="form-control" 
                                  id="PHYSICAL_ADDRESS" value="{{ old('PHYSICAL_ADDRESS', $user->PHYSICAL_ADDRESS) }}">
                        </div>
                    </div>

                     <div class="row mb-3">
                          <!-- County -->
                          <div class="col-md-6">
                              <label for="COUNTY" class="form-label">County of Residence</label>
                              <input name="COUNTY" type="text" class="form-control" 
                                    id="COUNTY" value="{{ old('COUNTY', $user->COUNTY) }}">
                          </div>

                          <!-- LinkedIn Profile -->
                          <div class="col-md-6">
                              <label for="LINKEDIN" class="form-label">LinkedIn Profile</label>
                              <input name="LINKEDIN" type="text" class="form-control" 
                                    id="LINKEDIN" value="{{ old('LINKEDIN', $user->LINKEDIN) }}">
                          </div>
                      </div>


                      <div class="row mb-3">
                          <!-- Name of School -->
                          <div class="col-md-6">
                              <label for="SCHOOL_NAME" class="form-label">School Name</label>
                              <input name="SCHOOL_NAME" type="text" class="form-control" 
                                    id="SCHOOL_NAME" value="{{ old('SCHOOL_NAME', $user->SCHOOL_NAME) }}">
                          </div>

                          <!-- Current Highest Level of Education -->
                          <div class="col-md-6">
                              <label for="EDUCATION_LEVEL" class="form-label">Current Highest Level of Education</label>
                              <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" required class="form-select">
                                  <option value="" disabled {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) ? '' : 'selected' }}>Select level</option>
                                  <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                  <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                  <option value="Masters Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                  <option value="PhD" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'PhD' ? 'selected' : '' }}>PhD</option>
                              </select>
                          </div>
                      </div>

                        <div class="row mb-3">
                          <!-- Current Year of Study -->
                          <div class="col-md-6">
                              <label for="SCHOOL_REGISTRATION_NUMBER" class="form-label">Current Year of Study</label>
                                <select id="SCHOOL_REGISTRATION_NUMBER" name="SCHOOL_REGISTRATION_NUMBER" class="form-control" required style="height: auto;">
                                    <option value="" disabled {{ old('SCHOOL_REGISTRATION_NUMBER', $user->SCHOOL_REGISTRATION_NUMBER) ? '' : 'selected' }}>Select Year</option>
                                    <option value="1" {{ old('SCHOOL_REGISTRATION_NUMBER') == '1' ? 'selected' : '' }}>Year 1</option>
                                    <option value="2" {{ old('SCHOOL_REGISTRATION_NUMBER') == '2' ? 'selected' : '' }}>Year 2</option>
                                    <option value="3" {{ old('SCHOOL_REGISTRATION_NUMBER') == '3' ? 'selected' : '' }}>Year 3</option>
                                    <option value="4" {{ old('SCHOOL_REGISTRATION_NUMBER') == '4' ? 'selected' : '' }}>Year 4</option>
                                </select>
                          </div>

                          <!-- Current Semester -->
                          <div class="col-md-6">
                              <label for="PREVIOUS_SCHOOL_NAME" class="form-label">Current Semester</label>
                              <select id="PREVIOUS_SCHOOL_NAME" name="PREVIOUS_SCHOOL_NAME" required class="form-select">
                                  <option value="" disabled {{ old('PREVIOUS_SCHOOL_NAME', $user->PREVIOUS_SCHOOL_NAME) ? '' : 'selected' }}>Select Semester</option>
                                    <option value="1" {{ old('PREVIOUS_SCHOOL_NAME') == '1' ? 'selected' : '' }}>semester 1</option>
                                    <option value="2" {{ old('PREVIOUS_SCHOOL_NAME') == '2' ? 'selected' : '' }}>semester 2</option>
                                </select>
                              </select>
                          </div>
                      </div>

                      <div class="row mb-3">
                        <!-- Program of study-->
                        <div class="col-md-6">
                            <label for="PROGRAM_OF_STUDY" class="form-label">Program of Study</label>
                                <input name="PROGRAM_OF_STUDY" type="text" class="form-control" 
                                  id="PROGRAM_OF_STUDY" value="{{ old('PROGRAM_OF_STUDY', $user->PROGRAM_OF_STUDY) }}">
                        </div>

                        <!-- 	Date -->
                      <div class="col-md-6">
                          <label for="DATE" class="form-label">Date</label>
                          <input name="DATE" type="date" class="form-control" 
                                id="DATE" value="{{ old('DATE', $user->DATE) }}">
                      </div>

                    </div>
                 </div>
              </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 30px;">Update Profile</button>
          
                    <!-- <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                      </div>
                    </div> -->
                    </div>
                  </form><!-- End Profile Edit Form -->
      </div>    
            <style>
            .readonly-select {
                pointer-events: none;   /* disables clicking */
                background-color: #e9ecef; /* same style as readonly inputs */
            }
            </style>
         @endif


        <!-- STUDENT PROFILE -->
        @if(auth()->user()->hasRole('student'))
        <div class="tab-content pt-2">

          <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <!-- <h5 class="card-title">About</h5>
                  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

                  <h5 class="card-title">Profile Details</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{ $user->TITTLE }} {{ $user->FIRST_NAME }} {{ $user->MIDDLE_NAME }} {{ $user->LAST_NAME }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->EMAIL }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Gender</div>
                    <div class="col-lg-9 col-md-8">{{ $user->GENDER }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Disability Status</div>
                    <div class="col-lg-9 col-md-8">{{ $user->DISABILITY_STATUS }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Type of Disability</div>
                    <div class="col-lg-9 col-md-8">{{ $user->DISABILITY_TYPE ?: 'No disability' }}</div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">National ID Number</div>
                    <div class="col-lg-9 col-md-8">{{ $user->NATIONAL_ID_NUMBER }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone Number</div>
                    <div class="col-lg-9 col-md-8">{{ $user->PHONE_NUMBER }}</div>
                  </div>

                   <div class="row">
                      <div class="col-lg-3 col-md-4 label">Institution</div>
                      <div class="col-lg-9 col-md-8">{{ $user->SCHOOL_NAME ?: 'N/A' }}</div>
                  </div>

                   <div class="row">
                      <div class="col-lg-3 col-md-4 label">Level of Education</div>
                      <div class="col-lg-9 col-md-8">{{ $user->EDUCATION_LEVEL ?: 'N/A' }}</div>
                  </div>
                  
                  <div class="row">
                      <div class="col-lg-3 col-md-4 label">Program of Study</div>
                      <div class="col-lg-9 col-md-8">{{ $user->PREVIOUS_PROGRAM_OF_STUDY ?: 'N/A' }}</div>
                  </div>

                   <div class="row">
                      <div class="col-lg-3 col-md-4 label">Current Year</div>
                      <div class="col-lg-9 col-md-8">Year {{ $user->SCHOOL_REGISTRATION_NUMBER ?: 'N/A' }}</div>
                  </div>

                   <div class="row">
                      <div class="col-lg-3 col-md-4 label">Current Semester</div>
                      <div class="col-lg-9 col-md-8">Semester {{ $user->PREVIOUS_SCHOOL_NAME ?: 'N/A' }}</div>
                  </div>

                  <div class="row">
                      <div class="col-lg-3 col-md-4 label">Membership Date</div>
                      <div class="col-lg-9 col-md-8">{{ $user->DATE ?: 'N/A' }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Postal Address</div>
                    <div class="col-lg-9 col-md-8">{{ $user->POSTAL_ADDRESS }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label"> Pysical Address</div>
                    <div class="col-lg-9 col-md-8">{{ $user->PHYSICAL_ADDRESS }}</div>
                  </div>
                  <div class="row">
                      <div class="col-lg-3 col-md-4 label">County of Residence</div>
                      <div class="col-lg-9 col-md-8">
                          {{ $user->COUNTY ?: 'N/A' }}
                      </div>
                  </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 label">Linkedin Profile</div>
                    <div class="col-lg-9 col-md-8">
                        {{ $user->LINKEDIN ?: 'N/A' }}
                    </div>
                </div>
            </div>

      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
         <form action="{{ route('profile.update', $user->ID) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
                @csrf
                @method('PUT')
                  <div class="row mb-3">
                      <label for="PASSPORT_PHOTO" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="{{ asset($user->PASSPORT_PHOTO) }}" alt="Upload Profile">
                        <div class="pt-2">
                         <div class="form-group">
                              <label for="PASSPORT_PHOTO" class="form-label" style="font-weight: 600; color: #333;">
                                  <!-- Passport Photo <span class="text-danger">*</span> -->
                              </label>

                              <!-- Hidden File Input -->
                              <input type="file" id="PASSPORT_PHOTO" name="PASSPORT_PHOTO" 
                                    accept=".jpeg,.png,.jpg" 
                                    class="d-none">

                              <!-- Styled Button as Upload Trigger -->
                              <label for="PASSPORT_PHOTO" class="btn btn-primary btn-sm" title="Upload new profile image" style="border-radius: 6px; color: white;">
                                  <i class="bi bi-upload"></i>
                              </label>

                              <!-- Show filename after selection -->
                              <span id="file-name" class="ms-2 text-muted" style="font-size: 14px;">No file chosen</span>
                          </div>

                          <script>
                              document.getElementById("PASSPORT_PHOTO").addEventListener("change", function() {
                                  const fileName = this.files[0] ? this.files[0].name : "No file chosen";
                                  document.getElementById("file-name").textContent = fileName;
                              });
                          </script>
                          <!-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                        </div>
                      </div>
                    </div>

                   <div class="row mb-3">
                    <!-- Tittle -->
                      <div class="col-md-4 mb-3">
                          <label for="TITTLE" class="form-label">Title</label>
                          <select name="TITTLE" id="TITTLE" class="form-select" required>
                              <option value="">-- Select Title --</option>
                              <option value="Mr."   {{ old('TITTLE', $user->TITTLE) === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                              <option value="Mrs."  {{ old('TITTLE', $user->TITTLE) === 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                              <option value="Ms."   {{ old('TITTLE', $user->TITTLE) === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                              <option value="Dr."   {{ old('TITTLE', $user->TITTLE) === 'Dr.' ? 'selected' : '' }}>Dr.</option>
                              <option value="Prof." {{ old('TITTLE', $user->TITTLE) === 'Prof.' ? 'selected' : '' }}>Prof.</option>
                          </select>
                      </div>
                        <!-- First Name -->
                      <div class="col-md-8">
                         <label for="FIRST_NAME" class="form-label">Name (As they appear on your Certificate)</label>
                            <input name="FIRST_NAME" type="text" class="form-control" 
                                  id="FIRST_NAME" value="{{ old('FIRST_NAME', $user->FIRST_NAME) }}"style= " background-color: #e9ecef;" readonly>
                        </div>
                    </div>

                      <div class="row mb-3">
                        <!-- Email -->
                         <div class="col-md-6">
                          <label for="EMAIL" class="form-label">Email</label>
                            <input name="EMAIL" type="text" class="form-control" 
                                  id="EMAIL" value="{{ old('EMAIL', $user->EMAIL) }}" style= " background-color: #e9ecef;" readonly>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="GENDER" class="form-label">Gender</label>
                            <select id="GENDER" name="GENDER" class="form-select readonly-select">
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('GENDER', $user->GENDER) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('GENDER', $user->GENDER) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>


                    <div class="row mb-3">
                        <!-- National id number-->
                        <div class="col-md-6">
                         <label for="NATIONAL_ID_NUMBER" class="form-label">National id Number</label>
                            <input name="NATIONAL_ID_NUMBER" type="text" class="form-control" 
                                  id="NATIONAL_ID_NUMBER" value="{{ old('NATIONAL_ID_NUMBER', $user->NATIONAL_ID_NUMBER) }}" style= " background-color: #e9ecef;" readonly>
                        </div>

                        <!-- 	PHONE_NUMBER  -->
                       <div class="col-md-6">
                          <label for="PHONE_NUMBER" class="form-label">Phone Number</label>
                            <input name="PHONE_NUMBER" type="text" class="form-control" 
                                  id="PHONE_NUMBER" value="{{ old('PHONE_NUMBER', $user->PHONE_NUMBER) }}" style= " background-color: #e9ecef;" readonly>
                        </div>
                    </div>

                     <div class="row mb-3">
                        <!-- Disability Status-->
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

                    <div class="row mb-3">
                        <!-- Postal Address-->
                        <div class="col-md-6">
                            <label for="POSTAL_ADDRESS" class="form-label">Postal Address</label>
                                <input name="POSTAL_ADDRESS" type="text" class="form-control" 
                                  id="POSTAL_ADDRESS" value="{{ old('POSTAL_ADDRESS', $user->POSTAL_ADDRESS) }}">
                        </div>

                        <!-- 	Pysical Address -->
                       <div class="col-md-6">
                        <label for="PHYSICAL_ADDRESS" class="form-label">Physical Address</label>
                            <input name="PHYSICAL_ADDRESS" type="text" class="form-control" 
                                  id="PHYSICAL_ADDRESS" value="{{ old('PHYSICAL_ADDRESS', $user->PHYSICAL_ADDRESS) }}">
                        </div>
                    </div>

                     <div class="row mb-3">
                          <!-- County -->
                          <div class="col-md-6">
                              <label for="COUNTY" class="form-label">County of Residence</label>
                              <input name="COUNTY" type="text" class="form-control" 
                                    id="COUNTY" value="{{ old('COUNTY', $user->COUNTY) }}">
                          </div>

                          <!-- LinkedIn Profile -->
                          <div class="col-md-6">
                              <label for="LINKEDIN" class="form-label">LinkedIn Profile</label>
                              <input name="LINKEDIN" type="text" class="form-control" 
                                    id="LINKEDIN" value="{{ old('LINKEDIN', $user->LINKEDIN) }}">
                          </div>
                      </div>


                      <div class="row mb-3">
                          <!-- Name of School -->
                          <div class="col-md-6">
                              <label for="SCHOOL_NAME" class="form-label">School Name</label>
                              <input name="SCHOOL_NAME" type="text" class="form-control" 
                                    id="SCHOOL_NAME" value="{{ old('SCHOOL_NAME', $user->SCHOOL_NAME) }}">
                          </div>

                          <!-- Current Highest Level of Education -->
                          <div class="col-md-6">
                              <label for="EDUCATION_LEVEL" class="form-label">Current Highest Level of Education</label>
                              <select id="EDUCATION_LEVEL" name="EDUCATION_LEVEL" required class="form-select">
                                  <option value="" disabled {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) ? '' : 'selected' }}>Select level</option>
                                  <option value="Undergraduate Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Undergraduate Degree' ? 'selected' : '' }}>Undergraduate Degree</option>
                                  <option value="Post Graduate Diploma" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Post Graduate Diploma' ? 'selected' : '' }}>Post Graduate Diploma</option>
                                  <option value="Masters Degree" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'Masters Degree' ? 'selected' : '' }}>Masters Degree</option>
                                  <option value="PhD" {{ old('EDUCATION_LEVEL', $user->EDUCATION_LEVEL) === 'PhD' ? 'selected' : '' }}>PhD</option>
                              </select>
                          </div>
                      </div>

                        <div class="row mb-3">
                          <!-- Current Year of Study -->
                          <div class="col-md-6">
                              <label for="SCHOOL_REGISTRATION_NUMBER" class="form-label">Current Year of Study</label>
                                <select id="SCHOOL_REGISTRATION_NUMBER" name="SCHOOL_REGISTRATION_NUMBER" class="form-control" required style="height: auto;">
                                    <option value="" disabled {{ old('SCHOOL_REGISTRATION_NUMBER', $user->SCHOOL_REGISTRATION_NUMBER) ? '' : 'selected' }}>Select Year</option>
                                    <option value="1" {{ old('SCHOOL_REGISTRATION_NUMBER') == '1' ? 'selected' : '' }}>Year 1</option>
                                    <option value="2" {{ old('SCHOOL_REGISTRATION_NUMBER') == '2' ? 'selected' : '' }}>Year 2</option>
                                    <option value="3" {{ old('SCHOOL_REGISTRATION_NUMBER') == '3' ? 'selected' : '' }}>Year 3</option>
                                    <option value="4" {{ old('SCHOOL_REGISTRATION_NUMBER') == '4' ? 'selected' : '' }}>Year 4</option>
                                </select>
                          </div>

                          <!-- Current Semester -->
                          <div class="col-md-6">
                              <label for="PREVIOUS_SCHOOL_NAME" class="form-label">Current Semester</label>
                              <select id="PREVIOUS_SCHOOL_NAME" name="PREVIOUS_SCHOOL_NAME" required class="form-select">
                                  <option value="" disabled {{ old('PREVIOUS_SCHOOL_NAME', $user->PREVIOUS_SCHOOL_NAME) ? '' : 'selected' }}>Select Semester</option>
                                    <option value="1" {{ old('PREVIOUS_SCHOOL_NAME') == '1' ? 'selected' : '' }}>semester 1</option>
                                    <option value="2" {{ old('PREVIOUS_SCHOOL_NAME') == '2' ? 'selected' : '' }}>semester 2</option>
                                </select>
                              </select>
                          </div>
                      </div>

                      <div class="row mb-3">
                        <!-- Program of study-->
                        <div class="col-md-6">
                            <label for="PREVIOUS_PROGRAM_OF_STUDY" class="form-label">Program of Study</label>
                                <input name="PREVIOUS_PROGRAM_OF_STUDY" type="text" class="form-control" 
                                  id="PREVIOUS_PROGRAM_OF_STUDY" value="{{ old('PREVIOUS_PROGRAM_OF_STUDY', $user->PREVIOUS_PROGRAM_OF_STUDY) }}">
                        </div>

                        <!-- 	Date -->
                      <div class="col-md-6">
                          <label for="DATE" class="form-label">Date</label>
                          <input name="DATE" type="date" class="form-control" 
                                id="DATE" value="{{ old('DATE', $user->DATE) }}" style= " background-color: #e9ecef;" readonly>
                      </div>

                    </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Update Profile</button>
          </div>
                    <!-- <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                      </div>
                    </div> -->
                    </div>
                  </form><!-- End Profile Edit Form -->
                  
            <style>
            .readonly-select {
                pointer-events: none;   /* disables clicking */
                background-color: #e9ecef; /* same style as readonly inputs */
            }
            </style>
         @endif

     </div>
  </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
      <style>
          /* Logged-in users: left content */
                #main.main-auth {
                  text-align: left;
                }
                
                /* Guests: align content left */
                #main.main-guest {
                  text-align: left;    /* guest users' content aligned left */
                  margin-left: 0 !important; /* remove sidebar spacing */
                }
                
      </style>
</section>
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