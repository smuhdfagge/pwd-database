<!DOCTYPE html>
<html>
<head>
    <title>PLWDs Report</title>
    <style>
        @page {
            margin: 100px 50px 80px 50px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 100px; /* Add space for footer */
        }
        th {
            background-color: #28a745;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            background-color: white;
        }
        .footer p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/vpesdilogo.jpg') }}" alt="V-PeSDI Logo">
        <h1>V-PeSDI PLWDs Database Report</h1>
        <p>Generated on: {{ date('d F Y, H:i A') }}</p>
        <p><strong>Total Records: {{ $plwds->count() }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>State</th>
                <th>LGA</th>
                <th>Disability Type</th>
                <th>Education Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plwds as $profile)
                <tr>
                    <td>{{ $profile->id }}</td>
                    <td>{{ $profile->user->name }}</td>
                    <td>{{ $profile->gender }}</td>
                    <td>{{ $profile->state }}</td>
                    <td>{{ $profile->lga }}</td>
                    <td>{{ $profile->disabilityType?->name }}</td>
                    <td>{{ $profile->educationLevel?->name }}</td>
                    <td>{{ $profile->verified ? 'Verified' : 'Pending' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} V-PeSDI PLWDs Database. All rights reserved.</p>
        <p>Empowering Persons Living With Disabilities</p>
    </div>
</body>
</html>
