<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Clearance Certificate</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Open+Sans:wght@300;400;600&display=swap');
        
        @page {
            size: A4; /* Specify A4 page size */
            margin: 10mm; /* Set margins to prevent content overflow */
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.4; /* Adjust line height for better fitting */
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 10px; /* Reduce body padding */
        }
        .certificate {
            max-width: 100%; /* Use full width of the page */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 2px solid gold;
            padding: 20px; /* Reduce padding */
            position: relative;
            page-break-inside: avoid; /* Prevent page break inside certificate */
        }
        .header {
            text-align: center;
            margin-bottom: 20px; /* Adjust margin */
            border-bottom: 2px solid gold;
            padding-bottom: 15px; /* Adjust padding */
        }
        .logo {
            width: 100px; /* Adjust logo size */
            margin-bottom: 10px;
        }
        h1 {
            font-family: 'Merriweather', serif;
            color: #003366;
            margin: 0;
            font-size: 24px; /* Reduce font size */
            text-transform: uppercase;
            letter-spacing: 1px; /* Adjust letter spacing */
        }
        .subtitle {
            font-size: 16px; /* Reduce font size */
            color: #666;
            margin-top: 5px;
        }
        .content {
            margin-top: 20px; /* Reduce margin */
        }
        .student-info {
            margin-bottom: 20px; /* Adjust margin */
        }
        .student-info p {
            margin: 4px 0; /* Adjust margin */
            font-size: 14px; /* Reduce font size */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px; /* Reduce margin */
            margin-bottom: 20px; /* Reduce margin */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px; /* Reduce padding */
            text-align: left;
            font-size: 14px; /* Adjust font size */
        }
        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            margin-top: 20px; /* Reduce margin */
            font-size: 12px; /* Reduce font size */
            color: #666;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px; /* Reduce watermark size */
            color: rgba(0,0,0,0.03);
            pointer-events: none;
            z-index: 1;
        }
        .signature-section {
        margin-top: 30px;
        display: flex;
        flex-direction: row; /* Ensure horizontal layout */
        justify-content: space-between;
        border-top: 1px solid #000;
        padding-top: 20px;
    }
    .signature {
        text-align: center;
        flex: 0 1 48%; /* Allow shrinking, don't grow, and take up roughly half the width */
        margin: 0 1%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .signature img {
        max-width: 150px;
        height: auto;
        margin-top: 10px;
    }
    .signature p {
        margin: 5px 0;
        font-size: 14px;
    }
    .signature-line {
        width: 100%;
        border-top: 1px solid #000;
        margin: 10px 0;
    }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="watermark">OFFICIAL</div>
        <div class="header">
            <img src="{{ public_path('images/KDU.png') }}" alt="University Logo" class="logo">
            <h1>General Sir John Kotelawala Defence University</h1>
            <p class="subtitle">Official Clearance Certificate</p>
        </div>

        <div class="content">
            <div class="student-info">
                <p><strong>Name:</strong> {{ $user->user_name }}</p>
                <p><strong>Registration Number:</strong> {{ $studentInfo->student_reg_no }}</p>
                <p><strong>Faculty:</strong> {{ $studentInfo->faculty->faculty_name }}</p>
                <p><strong>Application ID:</strong> {{ $application->id }}</p>
            </div>

            <h2>Department Clearance Status</h2>
            <table>
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Updated By</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departmentStatuses as $status)
                        @if (!in_array($status->department->dep_name, ['Student', 'Top level management']))
                            <tr>
                                <td>{{ $status->department->dep_name }}</td>
                                <td>{{ $status->status }}</td>
                                <td>{{ $status->reason }}</td>
                                <td>{{ $status->person_name }}</td>
                                <td>{{ $status->rank }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="signature-section">
            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature of the Approving Authority</p>
                <img src="{{ public_path('images/signature1.png') }}" alt="Signature" />
                <p>Name of the Authority</p>
                <p>Position</p>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature of the Registrar</p>
                <img src="{{ public_path('images/signature2.png') }}" alt="Signature" />
                <p>Name of the Registrar</p>
                <p>Registrar</p>
            </div>
        </div>
        <div class="footer">
            <p>This is an official clearance document issued by General Sir John Kotelawala Defence University.</p>
            <p>Kandawala Estate, Ratmalana, Sri Lanka</p>
        </div>
    </div>
</body>
</html>
