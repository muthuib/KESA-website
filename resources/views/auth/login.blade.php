<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
    }

 

    /* Split Layout */
    .split-container {
      display: flex;
      min-height: 100vh;
      margin-top: 56px; /* offset for sticky nav */
    }

    /* Left Image with subtle zoom animation */
    .left-image {
      flex: 1;
      background: url('{{ asset('pictures/10.jpg') }}') no-repeat center center;
      background-size: cover;
      animation: zoomInOut 20s infinite alternate ease-in-out;
    }

    @keyframes zoomInOut {
      from { transform: scale(1); }
      to { transform: scale(1.1); }
    }

    /* Right Login Section */
    .right-login {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
      background: linear-gradient(to right, #ffffff, #f8f9fa);
    }

    /* Login Card */
    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 450px;
      animation: fadeInUp 0.8s ease;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #333;
    }

    /* Logo */
    .logo-containers {
      display: flex;
      justify-content: center;
      margin-bottom: 15px;
    }

    .logo-containers img {
      max-width: 120px;
      height: auto;
    }

    /* Form Controls */
    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      border: 1px solid #ddd;
      transition: all 0.3s ease-in-out;
    }
    .form-control:focus {
      border-color: #00a859;
      box-shadow: 0 0 8px rgba(0,168,89,0.3);
    }

    /* Password toggle */
    .password-wrapper {
      position: relative;
    }
    .password-wrapper .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
    }

    /* Button */
    .btn-primary {
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease-in-out;
      background-color: #006f3c;
      border: none;
    }
    .btn-primary:hover {
      background-color: #00a859;
      transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 991.98px) {
      .left-image { display: none; }
      .split-container { flex-direction: column; margin-top: 56px; }
    }

    /* Animations */
    @keyframes fadeInUp {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>
  <!-- Top Navigation -->
  @include('dashboard.topnav')

  <!-- Wrapper -->
  <div class="split-container">
    <div class="left-image"></div>

    <div class="right-login">
      <div class="login-container">
        <!-- Logo -->
        <div class="logo-containers">
          <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo">
        </div>

        <h2><i class="bi bi-box-arrow-in-right"></i> Member Login</h2>

        <!-- Alerts -->
        @if (session('resent'))
          <div class="alert alert-success">A fresh verification link has been sent to your email address.</div>
        @endif
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- Email -->
          <div class="mb-3">
            <label for="EMAIL" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="EMAIL" value="{{ old('EMAIL') }}" required>
            @error('EMAIL') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <!-- Password with eye toggle -->
          <div class="mb-3 password-wrapper">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <i class="bi bi-eye-slas toggle-password" id="togglePassword"></i>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-primary w-100">Login</button>

          <!-- Links -->
          <div class="mt-3 text-center">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
          </div>
          <div class="mt-2 text-center">
            Don't have an account? <a href="{{ route('memberships.types') }}">Register</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Password toggle script -->
  <script>
    document.getElementById("togglePassword").addEventListener("click", function () {
      const passwordField = document.getElementById("password");
      const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      this.classList.toggle("bi-eye");
      this.classList.toggle("bi-eye-slash");
    });
  </script>
</body>
</html>
