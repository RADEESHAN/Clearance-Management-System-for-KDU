<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Requests</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: left;
            margin-bottom: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 10px;
        }

        .student-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .student-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 15px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .student-info {
            display: flex;
            align-items: center;
        }

        .student-avatar {
            margin-right: 15px;
        }

        .avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff;
        }

        .student-details {
            font-size: 14px;
            color: #333;
        }

        .student-details h3 {
            font-size: 16px;
            margin: 0;
            margin-bottom: 5px;
            color: #007bff;
        }

        .status {
            font-size: 14px;
            font-weight: bold;
        }

        .status.approved {
            color: #27ae60;
        }

        .status.declined {
            color: #e74c3c;
        }

        .status.pending {
            color: #f39c12;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve-btn {
            background-color: #27ae60;
            color: white;
        }

        .decline-btn {
            background-color: #e74c3c;
            color: white;
        }

        .disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
@include('components.nav')
<body>
    <div class="container">
        <h2>Clearance Requests</h2>

        <div class="search-bar">
            <input type="text" id="search-name" placeholder="Search by name..." onkeyup="filterByName()">
            <select id="status-filter" class="filter-select" onchange="filterByStatus()">
                <option value="">Filter by status</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Declined">Declined</option>
            </select>
        </div>

        <div class="student-list" id="student-list">
    @foreach($applications as $application)
    <div class="student-card" data-name="{{ strtolower($application->user->user_name ?? '') }}" data-status="{{ strtolower($application->applicationStatuses->last()->status ?? '') }}">
        <div class="student-info">
            
            <div class="student-details">
                <h3>Application ID: {{ $application->id }}</h3>
                <p>Name: {{ $application->user->user_name ?? 'N/A' }}</p>
                <p>Student ID: {{ $application->student_id }}</p>

                <!-- Loop through all application statuses -->
                @foreach($application->applicationStatuses as $status)
                <p class="status 
                    @if($status->status == 'Pending') pending 
                    @elseif($status->status == 'Approved') approved 
                    @elseif($status->status == 'Declined') declined 
                    @endif">
                    Status: {{ $status->status }} 
                </p>
                @endforeach
            </div>
        </div>
        <div class="action-buttons">
            <form action="{{ route('updateStatus', $application->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="Approved">
                <button type="submit" class="approve-btn @if($application->applicationStatuses->last()->status == 'Approved') disabled @endif" @if($application->applicationStatuses->last()->status == 'Approved') disabled @endif>Approve</button>
            </form>
            <form action="{{ route('updateStatus', $application->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Declined">
            <button type="submit" class="decline-btn @if($application->applicationStatuses->last()->status == 'Approved' || $application->applicationStatuses->last()->status == 'Declined') disabled @endif" @if($application->applicationStatuses->last()->status == 'Approved' || $application->applicationStatuses->last()->status == 'Declined') disabled @endif>Decline</button>
        </form>
        </div>
    </div>
    @endforeach
</div>
    </div>

    <script>
        function filterByName() {
            const searchValue = document.getElementById('search-name').value.toLowerCase();
            const studentCards = document.querySelectorAll('.student-card');

            studentCards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(searchValue)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function filterByStatus() {
            const statusFilter = document.getElementById('status-filter').value.toLowerCase();
            const studentCards = document.querySelectorAll('.student-card');

            studentCards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (statusFilter === '' || status === statusFilter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>