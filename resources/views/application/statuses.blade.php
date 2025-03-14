@extends('components.sidebar.sidebar')

@section('content')
<div class="container">
    <h1 class="dashboard-title">Application Statuses for Application No.{{ $application->id }}</h1>
    
    <div class="card">
        <div class="card-header">Application Status by Department</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $status)
                        @if($status->department && !in_array($status->department->id, [1, 2]))
                            <tr>
                                <td>{{ $status->department->dep_name ?? 'N/A' }}</td>
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
                                <td>{{ $status->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

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
    margin-top: 0px;
    font-family: var(--text);
}

.container {
    max-width: 900px;
    margin: 0 auto;
    margin-top: 30px;
    padding: 0px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.dashboard-title {
    margin-top: 0;
    font-size: 2.5rem;
    color: #003366;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
}

.card {
    border: none;
    border-radius: 12px;
    background-color: #f8f9fa;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.card-header {
    background-color: #6699FF;
    color: #ffffff;
    padding: 20px;
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    border-radius: 12px 12px 0 0;
}

.card-body {
    padding: 20px;
}

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

.status-box {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    color: #ffffff;
    font-weight: bold;
    text-align: center;
}

.status-pending .status-box {
    background-color: #ffc107;
    color: #000000;
}

.status-rejected .status-box {
    background-color: #dc3545;
}

.status-approved .status-box {
    background-color: #28a745;
}

.status-hidden .status-box {
    background-color: #6c757d;
    color: #ffffff;
}
</style>