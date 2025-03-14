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
            height: 60px;
            width: auto;
            margin-right: 15px; /* Space between logo and text */
            vertical-align: middle;
        }

        .navbar-logo span {
            font-size: 24px;
            font-weight: bold;
            vertical-align: middle;
        }

        .navbar-links {
            display: flex;
            gap: 10px; /* Space between navbar items */
        }

        .navbar-item {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 18px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-item:hover {
            background-color: #2980b9;
            color: #ecf0f1;
            transform: scale(1.05);
            border-radius: 4px;
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
            <a href="{{ route('users.import-form') }}" class="navbar-item {{ Request::is('im*') ? 'is-active' : '' }}">
                Import Users
            </a>
            <a href="{{ route('departments.manage') }}" class="navbar-item {{ Request::is('manage*') ? 'is-active' : '' }}">
                Add/Delete Department 
            </a>
            <a href="{{ route('departments.add') }}" class="navbar-item {{ Request::is('add*') ? 'is-active' : '' }}">
                Add Staff
            </a>
            <a href="{{ route('departments.profile') }}" class="navbar-item {{ Request::is('user*') ? 'is-active' : '' }}">
                Profile
            </a>
        </div>
    </nav>

</body>
</html>