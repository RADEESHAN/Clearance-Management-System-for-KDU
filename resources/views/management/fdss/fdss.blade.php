<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->

</head>

@extends('layouts.Management')

@section('title', 'FDSS')

@section('content')
<style>
        /* body, html {
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
        } */
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
    </style>
</head>
<div class="container">

    <!-- Welcome Overlay -->
    <div class="welcome-overlay">Welcome to the FDSS KDU</div>
</div>


</div>
@endsection
