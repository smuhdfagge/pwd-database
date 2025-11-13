<!DOCTYPE html>
<html>
<head>
    <title>PLWDs Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>V-PeSDI PLWDs Database Report</h1>
        <p>Generated on: {{ date('d F Y, H:i A') }}</p>
        <p>Total Records: {{ $plwds->count() }}</p>
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
