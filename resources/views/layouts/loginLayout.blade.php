<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/basic_styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar {
            width: 100%;
            background-color: var(--mainColor); 
            padding-left: 50px;
            color: white;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            height: 110px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo {
            height: 80px;
            width: auto; 
            padding-right: 30px;
        }

        .header-text h1 {
            color: white;
            font-size: 1.5em;
            margin: 0;
            line-height: 1.1;
            font-weight: bold;
            font-family: var(--title-text);
            cursor: default;
        }

        .navbar-nav {
            list-style-type: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

    
        .content {
            margin-left: 250px;
            margin-top: 110px; /* Offset the content by the navbar height */
            padding: 20px;
            width: 100%;
        }

    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/KDU.png') }}" alt="KDU Logo" class="logo">
            <div class="header-text">
                <h1>Clearance Management <br>System - KDU</h1>
            </div>
        </div>
    </nav>


    <!-- Content Section -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
