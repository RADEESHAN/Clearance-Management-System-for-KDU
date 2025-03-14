<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
</head>

@extends('layouts.student')

<div class="navbar-container">
    @include('components.nav') <!-- Include the navbar here -->
</div>

@section('content')

<h1 class="dashboard-title">Detailed View</h1>
    <div> <!-- The main container -->
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
      
        
        @if ($application)
            <div class="card mt-4">
                <div class="card-header">Application Status by Department</div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Updated by</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departmentStatuses as $status)
    <tr>
        <td>{{ $status->department->dep_name }}</td>
        <td class="
            {{ $status->status === 'PENDING' ? 'status-pending' : '' }}
            {{ $status->status === 'REJECTED' ? 'status-rejected' : '' }}
            {{ $status->status === 'APPROVED' ? 'status-approved' : '' }}
            {{ $status->status === 'HIDDEN' ? 'status-hidden' : '' }}">
            <span class="status-box">
                {{ $status->status === 'HIDDEN' ? 'Status Hidden' : $status->status }}
            </span>
        </td>
        <td>{{ $status->reason }}</td>
        <td>{{ $status->updater->user_name }}</td>
    </tr>
@endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div> <!-- End of the main container -->

@endsection

<script>
    function disableSubmitButton(form) {
        form.querySelector('#submitButton').disabled = true;
        form.querySelector('#submitButton').textContent = 'Submitting...';
    }
</script>

<style>
:root {
    --text: "Roboto", sans-serif;
    --title-text: "Roboto Slab", serif;
    --mainColor: #6699FF;
    --textBoxBG: rgba(206, 223, 255, 0.5); 
    --blackText: #000000;
    --whiteText: #ffffff;
    --grayText: #656464;
}

body {
    margin: 0;
    margin-top: 100px; /* Adjusted for fixed navbar */
    font-family: var(--text);
}

.navbar-container {
    padding: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    background-color: #ffffff; /* Ensure navbar has a background */
}

/* Container Styling */
.container {
    max-width: 900px;
    margin: 0 auto;
    margin-top: 130px;
    padding: 30px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* Dashboard Title Styling */
.dashboard-title {
    margin-top: 0;
    font-size: 2.5rem;
    color: #003366;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
}

/* Form Container with Flexbox for Button Alignment */
.form-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

/* User Name Label Styling */
.user-name-label {
    font-weight: 500;
    margin-left: 20px;
    font-size: 1.8rem;
    color: #6699FF;
    padding-bottom: 0;
    line-height: 1.2; /* Adjust line height for spacing */
    display: flex;
    align-items: baseline;
}

/* Value Styling */
.form-value {
    margin-top: 0;
    font-weight: 500;
    margin-left: 20px;
    line-height: 0; /* Keep consistent with label */
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    background-color: #f8f9fa;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

/* Card Header Styling */
.card-header {
    background-color: #6699FF;
    color: #ffffff;
    padding: 20px;
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    border-radius: 12px 12px 0 0;
}

/* Card Body Styling */
.card-body {
    padding-top: 20px;
    padding-left: 20px;
    padding-right: 30px; 
    padding-bottom: 10px;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    font-size: 1.1rem;
    color: #333333;
    margin-bottom: 10px;
    display: block;
    font-weight: 500;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ced4da;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #003366;
    box-shadow: 0 0 6px rgba(0, 51, 102, 0.25);
    outline: none;
}

/* Button Styling */
.btn-primary {
    background-color: #47fa00;
    border: none;
    padding: 12px 25px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    width: auto; /* Adjust width */
    display: block;
    margin-left: auto; /* Align right */
    margin-bottom: 0;
}

.btn-primary:hover {
    background-color: #56d80a;
    cursor: pointer;
    margin-bottom: 0;

}

.btn-primary:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
    margin-bottom: 0;

}

/* Success Message Styling */
.alert-success {
    background: #a1f87f;
    color: #3c763d;
    border: 1px solid #3c763d;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 25px;
    text-align: center;
}

    /* Table Styling */
    .table {
        margin-top: 20px;
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background-color: #003366;
        color: #ffffff;
    }

    .table thead th {
        font-size: 1.1rem;
        padding: 15px;
        text-align: left;
    }

    .table tbody td {
        font-size: 1rem;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    /* Status Colors */
    .status-pending {
        color: #ffc107;
        font-weight: bold;
        border-radius: 20px;
    }

    .status-rejected {
        color: #dc3545;
        font-weight: bold;
    }

    .status-approved {
        color: #28a745;
        font-weight: bold;
    }

    /* Additional Status */
    .status-hidden {
        color: #6c757d;
        font-style: italic;
    }

    /* Button Container Styling */
    .button-container {
        text-align: right;
    }


    /* Status Box Styling */
.status-box {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    color: #ffffff;
    font-weight: bold;
    text-align: center;
}

.status-pending .status-box {
    background-color: #ffc107; /* Yellow for Pending */
    color: #000000; /* Black text for better readability */
}

.status-rejected .status-box {
    background-color: #dc3545; /* Red for Rejected */
}

.status-approved .status-box {
    background-color: #28a745; /* Green for Approved */
}

.status-hidden .status-box {
    background-color: #6c757d; /* Gray for Hidden */
    color: #ffffff;
}

</style>
