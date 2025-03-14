
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

        .sidebar {
            background-color: var(--whiteText);
            background-color: #f9f9f9;
            width: 250px;
            height: 100vh;
            padding: 10px;
            position: fixed;
            top: 110px; /* Align with the height of the top navbar */
            display: flex;
            flex-direction: column;
            align-items: baseline;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .sidebar ul {
            padding: 0;
            list-style-type: none;
            width: 100%;
            
        }

        .sidebar ul li {
            margin-bottom: 10px;
            text-align: center;
            
        }

        .sidebar a {
            background-color: #ededed;
            text-decoration: none;
            color:  var(--mainColor);
            font-weight: 500;
            font-size: 16px;
            display: block;
            padding: 10px;
            border-radius: 15px;
            transition: background-color 0.3s;
            height: 50px;
            align-content: center;
        }

        .sidebar a:hover {
            background-color:  var(--mainColor);
            color: var(--whiteText);
            font-weight: bold;
        }
        
        .depName {
            font-size: 20px; /* Font size */
            display: block; /* Make it a block element */
            padding-top: 20px;
            padding-bottom: 10px;
            text-align: center; /* Center the text */
            width: 100%; /* Full width */
            margin: 0; /* Remove default margin */
            cursor: default;
        }

        .sidebar .nav-link.logout-btn{
            margin-top: 0px;
            margin-bottom: 0;
        }


        .sidebar .nav-link.logout-btn:hover {
            background-color: rgb(218, 45, 45);
            color: white;
        }

        .vertical-line {
            width: 2px;                          /* Width of the vertical line */
            background-color: var(--mainColor);  /* Color of the vertical line */
            height: calc(100vh - 110px);         /* Full height minus navbar height */
            position: fixed;                      /* Fix position on the page */
            top: 110px;                           /* Align with the height of the navbar */
            left: 250px;                          /* Align next to the sidebar */
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

    <!-- Sidebar with Buttons and Links -->
    <div class="sidebar">
        <ul>
            <li><b class="depName">Student Dashboard</b></li>
            <hr>
            <li><a href="/student/dashboard" class="nav-link">Application</a></li>
            <li><a href="/page2" class="nav-link">Outstanding Payments</a></li>

            <li><a class="nav-link logout-btn" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- <li><a href="/page3" class="nav-link logout-btn">Logout</a></li> --}}
        </ul>

    </div>

    <!-- Vertical Line Between Sidebar and Content -->
    <div class="vertical-line"></div>

    <!-- Content Section -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
