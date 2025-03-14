@extends('components.sidebar.sidebar')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the HQ Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
            color: #fff;
            overflow: hidden;
        }
        .container {
            text-align: center;
            max-width: 900px;
            padding: 20px;
            color: #f0f4ff;
            background: url('https://kdu.ac.lk/wp-content/uploads/2022/09/DSC_2723-scaled.jpg') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            z-index: 1; /* Ensures this content is above other background elements */
            margin: 0 auto; /* Centers the container */
            position: relative;
        }

        .welcome-overlay {
            font-size: 2rem;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .cta-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 1.2rem;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        a.logout-link {
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            display: block;
            transition: color 0.3s ease;
        }

        a.logout-link:hover {
            color: #ff4d4d;
        }
    </style>
<title>HeadQuartes</title>
</head>
<div class="container">

    <!-- Welcome Overlay -->
    <!-- <div class="welcome-overlay">Welcome to the Head Quartes Dashboard</div> -->
</div>
    <!-- Logout Link -->
    <a href="{{ route('logout') }}" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Add more content here if needed -->

</div>




<style> 
/* Container Styling */
.container {
    width: calc(100vw - var(--sidebar-width));
    height: 100vh;
    min-height: 100vh;
    padding: var(--content-padding);
    background-color: #f0f4ff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    margin: 0 auto;
    overflow-y: auto;
    transition: width 0.3s ease;
}

/* Header Styling */
h1 {
    font-size: 2em;
    color: #003366;
    text-align: center;
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: bold;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    max-width: 96%;
    margin-left: auto;
    margin-right: auto;
    font-size: 0.9em;
}

/* Card Header Styling */
.card-header {
    background: #6699ff;
    color: white;
    padding: 12px;
    font-size: 1.4em;
    font-weight: bold;
    text-align: center;
    border-bottom: 2px solid #0047ab;
}

/* Card Body Styling */
.card-body {
    padding: 18px;
    line-height: 1.6;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 1.1em;
    color: #003366;
    margin-bottom: 8px;
    display: block;
    font-weight: 600;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 1em;
    border: 1px solid #ccc;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
    background-color: #f9f9f9;
}

.form-control:focus {
    border-color: #6699ff;
    box-shadow: 0 0 5px rgba(102, 153, 255, 0.5);
    outline: none;
}

/* Button Styling */
.btn-primary {
    background: #6699ff;
    border: none;
    padding: 12px 20px;
    font-size: 1.1em;
    color: white;
    border-radius: 8px;
    transition: background 0.3s ease;
    text-align: center;
    display: block;
    width: 100%;
    box-shadow: 0 6px 8px rgba(102, 153, 255, 0.3);
}

.btn-primary:hover {
    background: #557acc;
    cursor: pointer;
}

.btn-primary:disabled {
    background: #b3c7ff;
    cursor: not-allowed;
}





/* Ensure the body and html take up the full viewport height */
html, body {
    height: 100%;
    margin: 0;
    overflow: hidden;
}





/* Welcome Overlay Styling */
.welcome-overlay {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 51, 102, 0.7); /* Semi-transparent background color */
    color: white;
    padding: 10px 20px;
    font-size: 1.5em;
    font-weight: bold;
    text-align: center;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

</style>

@endsection



