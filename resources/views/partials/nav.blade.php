<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>
        /* Internal CSS for Navigation Bar */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }

        .navbar {
            background-color: #3498db;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            color: white;
        }

        .navbar-logo img {
            height: 80px;
            width: auto;
            margin-right: 15px; /* Space between logo and text */
        }

        .navbar-logo span {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-links {
            display: flex;
        }

        .navbar-item {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 18px;
            transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;
        }

        .navbar-item:hover {
            background-color: #2980b9;
            color: #ecf0f1;
            transform: scale(1.05);
        }

        .is-active {
            background-color: darkblue;
            color: #ecf0f1;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <!-- Logo Section -->
        <div class="navbar-logo">
            <img src="{{ asset('storage/images/crest.png') }}" alt="Logo">
            <span>ADMIN PORTAL - CMS</span>
        </div>

        <!-- Navigation Links -->
        <div class="navbar-links">
            <a href="{{ route('clearance.graph') }}" class="navbar-item {{ Request::is('clearance-graph*') ? 'is-active' : '' }}">
                Clearance Reports
            </a>
            <a href="{{ route('status.chart') }}" class="navbar-item {{ Request::is('status-chart*') ? 'is-active' : '' }}">
                Status Reports
            </a>
          
            <a href="{{ route('duration.chart') }}" class="navbar-item {{ Request::is('duration-chart*') ? 'is-active' : '' }}">
                Duration Reports
            </a>
            <a href="{{ route('user.profile') }}" class="navbar-item {{ Request::is('user.profile*') ? 'is-active' : '' }}">
                Profile
            </a>
        </div>
    </nav>

</body>
</html>