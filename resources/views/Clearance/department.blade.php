@extends('layouts.management')

@section('content')
<link rel="stylesheet" href="{{ asset('css/custome-style.css') }}">
<div>

    <!-- Sticky Department Header -->
    <div class="sticky-header">
        <!-- <h1 class="department-title">{{ auth()->user()->department->dep_name }}</h1> -->

        <div class="filter-container">

            <h2 class="total-requests">Total Requests: {{ $totalRequests }}</h2>
            <label><input type="checkbox" name="all_requests" id="allRequests" checked> All Requests</label>
            <label><input type="checkbox" name="approved_requests" id="approvedRequests"> Approved Requests</label>
            <label><input type="checkbox" name="rejected_requests" id="rejectedRequests"> Rejected Requests</label>
            <input type="text" class="search-input" placeholder="Search by Reg No" id="searchRegNo">

        </div>
    </div>

    <!-- Scrollable Panel -->
    <div class="container">
        <!-- Application List -->
        <ul class="application-list">
            @forelse($applicationStatuses as $status)
            <li class="application-item">
                <div class="application-header">
                    <h5>Application #{{ $status->application_id }}</h5>
                    @if(auth()->user()->dep_id != 14)
                    @php
                    $badgeClass = $status->status === 'APPROVED' ? 'status-approved' : 'status-rejected';
                    @endphp
                    <span class="status-badge {{ $badgeClass }}">{{ $status->status }}</span>
                    @endif
                </div>

                <!-- Application Details -->
                <div class="application-details">
                    <div class="detail-item"><strong>Reg. No:</strong> {{ $status->application->user->reg_no }}</div>
                    <div class="detail-item"><strong>Name:</strong> {{ $status->application->user->user_name }}</div>
                    <!-- Display Faculty Name from the Faculty relationship -->
                    <strong>Faculty:</strong> {{ $status->application->studentInfo->faculty->faculty_name ?? 'N/A' }}
                    <div class="detail-item"><strong>Tel. No:</strong>
                        {{ $status->application->user->studentInfo->tel_no ?? 'N/A' }}</div>
                    <div class="detail-item"><strong>KDU ID:</strong>
                        {{ $status->application->user->studentInfo->kdu_id ?? 'N/A' }}</div>
                    <div class="detail-item"><strong>Bank</strong>
                        {{ $status->application->user->studentInfo->bank ?? 'N/A' }}</div>
                    <div class="detail-item"><strong>Bank Acc No:</strong>
                        {{ $status->application->user->studentInfo->account_number ?? 'N/A' }}</div>
                    @if(auth()->user()->dep_id != 14)
                    @if($status->status === 'REJECTED')
                    <div class="detail-item"><strong>Reason:</strong> {{ $status->reason ?? 'N/A' }}</div>
                    @endif
                    <div class="detail-item"><strong>Status:</strong> {{ $status->status }}</div>
                    @endif
                    <div class="detail-item"><strong>Last Updated:</strong>
                        {{ $status->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div class="button-group">
                    <!-- PDF View Buttons on the Left -->
                    <div class="pdf-view-buttons">
                        @if(in_array(auth()->user()->dep_id, [12, 16]))
                        <button type="button" class="btn btn-pdf" onclick="generatePdf('{{ $status->id }}')">Generate
                            PDF</button>
                        @endif

                        @if(auth()->user()->dep_id == 13)
                        <button type="button" class="btn btn-hostel-pdf"
                            onclick="viewGeneratedPdf('{{ $status->application_id }}', 25)">View Hostel PDF</button>
                        <button type="button" class="btn btn-library-pdf"
                            onclick="viewGeneratedPdf('{{ $status->application_id }}', 12)">View Library PDF</button>
                        @endif
                    </div>

                    <div class="approval-buttons">
                        @if(auth()->user()->dep_id == 15)
                        <!-- For dep_id = 15: Show Approve and Decline Buttons -->
                        @if ($isEnlistment || ($isEnlistment && $status->allOthersApproved))
                        <!-- Approve Button (Enabled) -->
                        <form
                            action="{{ route('Clearance.update', ['departmentId' => auth()->user()->dep_id, 'statusId' => $status->id]) }}"
                            method="POST" onsubmit="return setPersonNameBeforeSubmit('{{ $status->id }}')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="APPROVED">
                            <button type="submit" class="btn btn-approve">Approve</button>
                        </form>
                        @else
                        <!-- Approve Button (Disabled) -->
                        <div class="approval-container">
                            <button class="btn btn-approve" disabled>Approve</button>
                            <small class="text-danger">Other departments are not completed</small>
                        </div>
                        @endif

                        <!-- Decline Button -->
                        @if(!(auth()->user()->dep_id == 15))
                        <button type="button" class="btn btn-decline"
                            onclick="declineApplication('{{ $status->id }}')">Decline</button>
                        @endif

                        @else
                        <!-- For Other Departments: Show Both Approve and Decline Buttons -->
                        <form
                            action="{{ route('Clearance.update', ['departmentId' => auth()->user()->dep_id, 'statusId' => $status->id]) }}"
                            method="POST" onsubmit="return setPersonNameBeforeSubmit('{{ $status->id }}')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="APPROVED">
                            <button type="submit" class="btn btn-approve">Approve</button>
                        </form>
                        <!-- Decline Button -->
                        <button type="button" class="btn btn-decline"
                            onclick="declineApplication('{{ $status->id }}')">Decline</button>
                        @endif

                        <!-- Receipt Button (Only Visible for dep_id = 13) -->
                        @if(auth()->user()->dep_id == 13)
                        <div class="receipt-buttons" style="margin-top: 10px;">
                            <button type="button" class="btn btn-receipt"
                                onclick="seeReceipt('{{ $status->application_id }}')">See Receipt</button>
                        </div>
                        @endif
                    </div>


                </div>
            </li>
            @empty
            <li class="application-item">
                <p class="text-center">No applications found.</p>
            </li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Decline Reason Modal -->
<div id="declineModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('declineModal')">&times;</span>
        <h3>Enter Reason for Declining</h3>
        <textarea id="declineReason" rows="4" placeholder="Enter reason here..."></textarea>
        <button id="submitDeclineBtn">Submit</button>
    </div>
</div>

<!-- Message Modal for Success/Error -->
<div id="messageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('messageModal')">&times;</span>
        <h3 id="messageTitle"></h3>
        <p id="messageBody"></p>
        <button onclick="closeModal('messageModal')">OK</button>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="modal">
    <div class="modal-content">
        <!-- Close button -->
        <span class="close" onclick="closeModal('receiptModal')">&times;</span>

        <!-- Modal Title -->
        <h2>All Receipts</h2>

        <!-- Receipts Container -->
        <div class="receipts-container">
            <!-- Dynamic content will be inserted here by JavaScript -->
        </div>

        <!-- Close Modal Button -->
        <button onclick="closeModal('receiptModal')" class="close-modal-btn">Close</button>
    </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', () => {
    const allRequestsCheckbox = document.getElementById('allRequests');
    const approvedRequestsCheckbox = document.getElementById('approvedRequests');
    const rejectedRequestsCheckbox = document.getElementById('rejectedRequests');
    const searchInput = document.getElementById('searchRegNo');
    const applicationItems = document.querySelectorAll('.application-item');

    // Function to filter applications
    function filterApplications() {
        const showAll = allRequestsCheckbox.checked;
        const showApproved = approvedRequestsCheckbox.checked;
        const showRejected = rejectedRequestsCheckbox.checked;
        const searchQuery = searchInput.value.trim().toLowerCase();

        applicationItems.forEach(item => {
            const statusBadge = item.querySelector('.status-badge');
            const regNoElement = item.querySelector(
                '.detail-item strong'); // Adjust selector for Reg. No field
            const status = statusBadge ? statusBadge.textContent.trim().toUpperCase() : null;
            const regNo = regNoElement ? regNoElement.parentElement.textContent.trim()
                .toLowerCase() :
                '';

            // Determine visibility
            const matchesStatus =
                (showAll) ||
                (showApproved && status === 'APPROVED') ||
                (showRejected && status === 'REJECTED');
            const matchesSearch = !searchQuery || regNo.includes(searchQuery);

            if (matchesStatus && matchesSearch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Event listeners for checkboxes and search input
    allRequestsCheckbox.addEventListener('change', () => {
        if (allRequestsCheckbox.checked) {
            approvedRequestsCheckbox.checked = false;
            rejectedRequestsCheckbox.checked = false;
        }
        filterApplications();
    });

    approvedRequestsCheckbox.addEventListener('change', () => {
        if (approvedRequestsCheckbox.checked) {
            allRequestsCheckbox.checked = false;
        }
        filterApplications();
    });

    rejectedRequestsCheckbox.addEventListener('change', () => {
        if (rejectedRequestsCheckbox.checked) {
            allRequestsCheckbox.checked = false;
        }
        filterApplications();
    });

    searchInput.addEventListener('input', () => {
        filterApplications();
    });

    // Initial filter to show all applications
    filterApplications();
});



////////////////////////////////////////////    
let declineStatusId = null;

function declineApplication(statusId) {
    console.log("Decline button clicked for status ID:", statusId);
    declineStatusId = statusId;
    document.getElementById("declineModal").style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function showMessageModal(title, message) {
    document.getElementById("messageTitle").innerText = title;
    document.getElementById("messageBody").innerText = message;
    document.getElementById("messageModal").style.display = "block";
}

document.getElementById("submitDeclineBtn").addEventListener("click", function() {
    const reason = document.getElementById("declineReason").value.trim();
    if (reason === "") {
        showMessageModal("Error", "Please provide a reason for declining.");
        return;
    }

    console.log("Reason provided:", reason);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('_method', 'PUT');
    formData.append('status', 'REJECTED');
    formData.append('reason', reason);

    fetch(`{{ route('Clearance.update', ['departmentId' => auth()->user()->dep_id, 'statusId' => ':statusId']) }}`
            .replace(':statusId', declineStatusId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessageModal("Success", data.message);
                setTimeout(() => location.reload(), 2000); // Reload after 2 seconds
            } else {
                showMessageModal("Error", data.message || "Unknown error occurred");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessageModal("Error", "An error occurred: " + error.message);
        });

    closeModal("declineModal"); // Close the reason input modal
});

function generatePdf(statusId) {
    console.log("Generate PDF button clicked for status ID:", statusId);

    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert("CSRF token not found. Please check your layout file.");
        return;
    }

    // Prompt the user for additional information or reasons
    var pdfReason = prompt("Please enter the reason or information for the PDF:");
    if (pdfReason == null || pdfReason.trim() === "") {
        console.log("PDF generation cancelled or no reason provided.");
        return; // Exit if no reason provided
    }

    console.log("Reason provided for PDF:", pdfReason);

    // Prepare the data to send
    var formData = new FormData();
    formData.append('_token', csrfToken.getAttribute('content'));
    formData.append('pdf_reason', pdfReason);

    // Make the fetch request
    fetch(`{{ route('Clearance.generatePdf', ['departmentId' => auth()->user()->dep_id, 'statusId' => ':statusId']) }}`
            .replace(':statusId', statusId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.message ||
                        `Network response was not ok (${response.status})`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert(data.message);
                // Optionally, provide a link to view the PDF
                // location.reload(); // Reload the page if needed
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        });
}

function viewGeneratedPdf(applicationId, departmentId) {
    console.log("Fetching PDF for Application:", applicationId, "Department:", departmentId);

    fetch(`/clearance/pdf/${departmentId === 25 ? 'hostel' : 'library'}/${applicationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.open(data.pdf_url, '_blank');
            } else {
                alert("PDF not found.");
            }
        })
        .catch(error => console.error("Error fetching PDF:", error));
}

function seeReceipt(applicationId) {
    console.log("See Receipt button clicked for application ID:", applicationId);

    fetch(`{{ route('Clearance.getReceipts', ['applicationId' => ':applicationId']) }}`.replace(':applicationId',
            applicationId), {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const receipts = data.data;
                const modalContent = document.getElementById('receiptModal').querySelector('.modal-content');
                modalContent.innerHTML = `
                <span class="close" onclick="closeModal('receiptModal')">&times;</span>
                <h2>All Receipts</h2>
                <div class="receipts-container">
                    ${Object.entries(receipts).map(([dept, deptReceipts]) => `
                        <div class="department-receipts">
                            <h3>${dept.charAt(0).toUpperCase() + dept.slice(1)} Receipts</h3>
                            ${deptReceipts.urls.map((url, index) => `
                                <div class="receipt-item">
                                    ${url.toLowerCase().endsWith('.pdf') ? 
                                        `<embed src="${url}" type="application/pdf" class="pdf-viewer">` :
                                        `<img src="${url}" alt="Receipt ${index + 1}" class="image-receipt">`
                                    }
                                    <a href="${url}" download class="download-link">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            `).join('')}
                        </div>
                    `).join('')}
                </div>
                <button onclick="closeModal('receiptModal')">Close</button>
            `;
                document.getElementById('receiptModal').style.display = 'block';
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside of the modal content
window.onclick = function(event) {
    const modal = document.getElementById('receiptModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>



<style>
/* Modal Styles */
.receipts-container {
    max-height: 70vh;
    overflow-y: auto;
    padding: 20px;
}

.department-receipts {
    margin-bottom: 30px;
}

.receipt-item {
    margin: 20px 0;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.pdf-viewer {
    width: 100%;
    height: 500px;
    margin-bottom: 10px;
}

.image-receipt {
    max-width: 100%;
    max-height: 400px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
}

.download-link {
    display: inline-block;
    padding: 5px 10px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}

.download-link:hover {
    background: #0056b3;
}

.modal-content {
    width: 80%;
    max-width: 1000px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    padding: 20px;
    width: 40%;
    margin: 10% auto;
    text-align: center;
    border-radius: 10px;
}

.close {
    float: right;
    font-size: 20px;
    cursor: pointer;
}

textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    resize: none;
}

button {
    padding: 10px 20px;
    background-color: green;
    color: white;
    border: none;
    cursor: pointer;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
    background-color: white;
    padding: 20px;
    width: 80%;
    max-width: 1000px;
    margin: 5% auto;
    border-radius: 10px;
    position: relative;
}

.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
}

.close:hover {
    color: #000;
}

.receipts-container {
    max-height: 70vh;
    overflow-y: auto;
    padding: 10px;
}

.department-receipts {
    margin-bottom: 30px;
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.department-receipts h3 {
    margin-bottom: 15px;
    color: #333;
    font-size: 18px;
}

.receipt-item {
    margin: 15px 0;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.pdf-viewer {
    width: 100%;
    height: 500px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
}

.image-receipt {
    max-width: 100%;
    max-height: 400px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.download-link {
    display: inline-block;
    padding: 8px 15px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    transition: background 0.3s ease;
}

.download-link:hover {
    background: #0056b3;
}

.download-link i {
    margin-right: 5px;
}

.close-modal-btn {
    display: block;
    margin: 20px auto 0;
    padding: 10px 20px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.close-modal-btn:hover {
    background: #c82333;
}
</style>

</div>
@endsection