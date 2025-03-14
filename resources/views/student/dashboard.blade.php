@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
@endphp

<head>
    <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Font Awesome -->
</head>

@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')

{{-- <h1 class="dashboard-title">Student Dashboard</h1> --}}
<div>
    <!-- The main container -->

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    {{-- <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">
        Logout
    </button>
    </form> --}}
    <div class="card">
        <div class="card-header">Clearance Application</div>
        <div class="card-body">
            <form method="POST" action="{{ route('student.submitClearanceForm') }}"
                onsubmit="disableSubmitButton(this)">
                @csrf
                <div class="form-container">
                    <!-- Existing Elements -->
                    <div class="left-column">
                        <div class="form-group">
                            <span class="user-name-label">{{ $user->user_name }}</span>
                        </div>
                        <div class="form-group">
                            <span class="form-value">{{ $studentInfo->student_reg_no }}</span>
                        </div>
                        <div class="form-group">
                            <span class="form-value">{{ $studentInfo->faculty->faculty_name }}</span>
                        </div>
                        <div class="form-group">
                            <span class="form-value">{{ ucwords(strtolower($studentInfo->student_type)) }}</span>
                        </div>
                    </div>
                    <!-- Input Fields -->
                    <div class="right-column">
                        <div class="form-group">
                            <label for="bank">Bank Name</label>
                            <input type="text" id="bank" name="bank" class="form-control"
                                value="{{ old('bank', $studentInfo->bank) }}" placeholder="Enter your bank name"
                                {{ $application ? 'readonly' : '' }} required>
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" id="account_number" name="account_number" class="form-control"
                                value="{{ old('account_number', $studentInfo->account_number) }}"
                                placeholder="Enter your account number" {{ $application ? 'readonly' : '' }} required>
                        </div>
                        <div class="form-group">
                            <label for="account_number_confirmation">Confirm Account Number</label>
                            <input type="text" id="account_number_confirmation" name="account_number_confirmation"
                                class="form-control" placeholder="Re-enter your account number"
                                {{ $application ? 'readonly' : '' }} required>
                        </div>
                    </div>
                </div>
        </div>

        <div class="button-container">
            <button type="submit" class="btn btn-primary" id="submitButton" {{ $application ? 'disabled' : '' }}>
                {{ $application ? 'Application Submitted' : 'Submit Clearance Form' }}
            </button>

            @if ($allApproved)
            <!-- Condition to check if all departments have approved -->
            <a href="{{ route('student.downloadClearancePDF') }}" class="downloadButton" id="downloadButton">
                Download Clearance
            </a>
            @else
            <button class="downloadButtonDisable" id="downloadButton" disabled>
                Download Clearance
            </button>
            @endif
        </div>
        </form>
    </div>
</div>

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
                    <th>Updated By</th>
                    <th>Service Number</th> <!-- Existing Rank Column -->
                    <th>PDF</th> <!-- New PDF Column -->
                    <th>Upload Receipt</th> <!-- New Upload Receipt Column -->
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
                    <td>{{ $status->updater->user_name ?? 'N/A' }}</td>
                    <td>{{ $status->updater->service_number ?? 'N/A' }}</td>

                    @if (in_array(strtolower($status->department->dep_name), ['library', 'hostal']))
                    {{-- PDF Column --}}
                    <td>
                        @if($status->pdf_path)
                        @php
                        // Determine the route based on department
                        $departmentName = strtolower($status->department->dep_name);
                        $routeName = $departmentName === 'hostal' ? 'clearance.pdf.hostel' :
                        'clearance.pdf.library';
                        $applicationId = $status->application_id ?? $status->id;
                        @endphp
                        <button class="btn btn-link view-pdf"
                            data-url="{{ route($routeName, ['applicationId' => $applicationId]) }}">
                            <i class="fas fa-file-pdf"></i> View PDF
                        </button>
                        @else
                        N/A
                        @endif
                    </td>
                    <div id="pdfModal"
                        style="display: none; position: fixed; top: 60; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8);">
                        <div
                            style="position: relative; width: 80%; height: 80%; margin: 5% auto; background: #fff; border-radius: 5px; overflow: hidden;">
                            <button id="closeModal"
                                style="position: absolute; top: 10px; right: 10px; background: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">X</button>
                            <iframe id="pdfIframe" style="width: 100%; height: 100%;" frameborder="0"></iframe>
                        </div>
                    </div>

                    <td>
                        @if($status->status === 'APPROVED' || $status->status === 'REJECTED')
                        <form method="POST" action="{{ route('student.uploadReceipt') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="department_id" value="{{ $status->department->id }}">
                            <div class="input-group">
                                <input type="file" name="receipt" accept="application/pdf,image/*" required>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </form>
                        @elseif(!empty($status->receipt_paths))
                        @foreach ($status->receipt_paths as $receipt)
                        <a href="{{ Storage::url($receipt) }}" target="_blank" class="receipt-link">
                            <i class="fas fa-file-upload"></i> View Receipt {{ $loop->iteration }}
                        </a>
                        @endforeach
                        @else
                        Pending Upload
                        @endif
                    </td>

                    @else
                    <td>N/A</td>
                    <td>N/A</td>
                    @endif

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script>
function disableSubmitButton(form) {
    form.querySelector('#submitButton').disabled = true;
    form.querySelector('#submitButton').textContent = 'Submitting...';
}
document.addEventListener('DOMContentLoaded', function() {
    const viewPdfButtons = document.querySelectorAll('.view-pdf');
    const modal = document.getElementById('pdfModal');
    const modalIframe = document.getElementById('pdfIframe');

    viewPdfButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.url;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Identifies this as an AJAX request
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.pdf_url) {
                        // Display the PDF in the modal
                        modalIframe.src = data.pdf_url;
                        modal.style.display = 'block';
                    } else {
                        alert('Failed to retrieve the PDF.');
                    }
                })
                .catch(error => {
                    console.log('Error fetching PDF:', error);
                    alert('An error occurred while fetching the PDF.');
                });
        });
    });

    // Close the modal
    document.getElementById('closeModal').addEventListener('click', function() {
        modal.style.display = 'none';
        modalIframe.src = ''; // Clear the iframe
    });
});

function validateAccountNumbers() {
    const accountNumber = document.getElementById('account_number').value;
    const confirmationNumber = document.getElementById('account_number_confirmation').value;
    if (accountNumber !== confirmationNumber) {
        alert('Account numbers do not match. Please check and re-enter.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission if validation passes
}
document.addEventListener('DOMContentLoaded', function() {
    const confirmationField = document.getElementById('account_number_confirmation');
    confirmationField.addEventListener('paste', (event) => {
        event.preventDefault(); // Disable pasting
        alert('Pasting is not allowed in the confirmation field.');
    });
    confirmationField.addEventListener('copy', (event) => {
        event.preventDefault(); // Disable copying
        alert('Copying is not allowed.');
    });
    confirmationField.addEventListener('cut', (event) => {
        event.preventDefault(); // Disable cutting
        alert('Cutting is not allowed.');
    });
});
</script>

@endsection