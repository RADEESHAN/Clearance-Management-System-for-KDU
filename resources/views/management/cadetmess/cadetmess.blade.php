<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->

</head>

@extends('layouts.Management')

@section('title', 'Cadet Mess')

@section('content')
<style>
        .container {
            text-align: center;
            max-width: 900px;
            padding: 20px;
            color: #f0f4ff;
            background-color: #6c757d !important;
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
</style>

<div class="container">
    <div class="welcome-overlay">Welcome to the Cadet Mess</div>
</div>

@endsection
