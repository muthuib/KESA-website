<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Toggle Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: brown;">
        <a class="navbar-brand ps-3" href="#">Brand</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Vision</a></li>
                        <li><a class="dropdown-item" href="#">Mission</a></li>
                        <li><a class="dropdown-item" href="#">Objectives</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="economicsHubDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Economics Hub
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="economicsHubDropdown">
                        <li><a class="dropdown-item" href="#">Resources</a></li>
                        <li><a class="dropdown-item" href="#">Research</a></li>
                        <li><a class="dropdown-item" href="#">Feedback</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Live Media</a>
                </li>
            </ul>
        </div>
    </nav>

    <div style="padding-top: 60px;">
        <!-- Content here -->
    </div>
</body>

</html>