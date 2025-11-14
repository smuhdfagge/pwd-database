<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 100px 50px 80px 50px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #212529 0%, #28a745 100%);
            color: white;
            padding: 15px 20px;
            margin-bottom: 15px;
            text-align: center;
        }

        .header img.logo {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 30%;
        }

        .header h1 {
            font-size: 16pt;
            margin-bottom: 2px;
            font-weight: bold;
        }

        .header p {
            font-size: 9pt;
            opacity: 0.9;
            margin: 0;
        }

        .profile-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .container {
            padding: 0 20px;
            margin-bottom: 80px;
        }

        .section-header {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            margin-top: 12px;
            margin-bottom: 8px;
            font-size: 11pt;
            font-weight: bold;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            page-break-inside: auto;
        }

        table.data-table {
            border: 1px solid #dee2e6;
        }

        table.data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table.data-table th {
            background-color: #f8f9fa;
            color: #212529;
            font-weight: bold;
            text-align: left;
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            width: 30%;
        }

        table.data-table td {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: bold;
        }

        .status-verified {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .skill-badge {
            display: inline-block;
            background-color: #d4edda;
            color: #155724;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 8px;
            font-size: 8pt;
        }

        table.education-table {
            width: 100%;
            border: 1px solid #dee2e6;
            margin-bottom: 8px;
            page-break-inside: auto;
        }

        table.education-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table.education-table th {
            background-color: #28a745;
            color: white;
            padding: 5px 8px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
            text-align: left;
        }

        table.education-table td {
            padding: 5px 8px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
        }

        table.document-table {
            width: 100%;
            border: 1px solid #dee2e6;
            page-break-inside: auto;
        }

        table.document-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table.document-table th {
            background-color: #28a745;
            color: white;
            padding: 5px 8px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
            text-align: left;
        }

        table.document-table td {
            padding: 5px 8px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
        }

        .bio-section {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 3px solid #28a745;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-top: 2px solid #28a745;
        }

        .footer p {
            font-size: 7pt;
            color: #666;
            margin: 1px 0;
            line-height: 1.3;
        }

        .no-data {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/vpesdilogo.jpg') }}" alt="V-PeSDI Logo" class="logo">
        <div class="header-content">
            <div class="header-left">
                <h1>V-PeSDI PLWDs Database</h1>
                <p>Persons with Disabilities Profile Document</p>
                <p style="font-size: 8pt; margin-top: 3px;">Generated: {{ $generatedDate }}</p>
            </div>
            <div class="header-right">
                @if($photoUrl)
                    <img src="{{ $photoUrl }}" alt="Profile Photo" class="profile-photo">
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Personal Information -->
        <div class="section-header">PERSONAL INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>Full Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ $profile->gender ?? 'Not specified' }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>
                    @if($profile->date_of_birth)
                        {{ $profile->date_of_birth->format('F d, Y') }} (Age: {{ $profile->age }} years)
                    @else
                        <span class="no-data">Not specified</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>{{ $profile->phone ?? 'Not specified' }}</td>
            </tr>
            <tr>
                <th>Profile Status</th>
                <td>
                    @if($profile->verified)
                        <span class="status-badge status-verified">✓ Verified</span>
                    @else
                        <span class="status-badge status-pending">⏳ Pending Verification</span>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Location Information -->
        <div class="section-header">LOCATION INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>State</th>
                <td>{{ $profile->state ?? 'Not specified' }}</td>
            </tr>
            <tr>
                <th>Local Government</th>
                <td>{{ $profile->lga ?? 'Not specified' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $profile->address ?? 'Not specified' }}</td>
            </tr>
        </table>

        <!-- Disability Information -->
        <div class="section-header">DISABILITY INFORMATION</div>
        <table class="data-table">
            <tr>
                <th>Disability Type</th>
                <td>{{ $profile->disabilityType->name ?? 'Not specified' }}</td>
            </tr>
            @if($profile->disabilityType && $profile->disabilityType->description)
            <tr>
                <th>Description</th>
                <td>{{ $profile->disabilityType->description }}</td>
            </tr>
            @endif
        </table>

        <!-- Education Information -->
        <div class="section-header">EDUCATION BACKGROUND</div>
        <table class="data-table">
            <tr>
                <th>Primary Education Level</th>
                <td>{{ $profile->educationLevel->name ?? 'Not specified' }}</td>
            </tr>
        </table>

        @if($profile->educationRecords && $profile->educationRecords->count() > 0)
        <div style="margin-top: 8px; margin-bottom: 3px; font-weight: bold; font-size: 9pt;">Education History:</div>
        <table class="education-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Level</th>
                    <th style="width: 30%;">Institution</th>
                    <th style="width: 20%;">Period</th>
                    <th style="width: 30%;">Certificate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profile->educationRecords as $record)
                <tr>
                    <td>{{ $record->educationLevel->name ?? 'N/A' }}</td>
                    <td>{{ $record->institution ?? 'N/A' }}</td>
                    <td>{{ $record->from_year ?? 'N/A' }} - {{ $record->to_year ?? 'Present' }}</td>
                    <td>{{ $record->certificate_obtained ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Skills & Competencies -->
        <div class="section-header">SKILLS & COMPETENCIES</div>
        @if($profile->skillsData && $profile->skillsData->count() > 0)
            <div style="padding: 5px 0;">
                @foreach($profile->skillsData as $skill)
                    <span class="skill-badge">{{ $skill->name }}</span>
                @endforeach
            </div>
        @else
            <p class="no-data" style="padding: 5px 0;">No skills listed</p>
        @endif

        <!-- Biography -->
        @if($profile->bio)
        <div class="section-header">BIOGRAPHY</div>
        <div class="bio-section">
            {{ $profile->bio }}
        </div>
        @endif

        <!-- Uploaded Documents -->
        @if($profile->uploads && $profile->uploads->count() > 0)
        <div class="section-header">UPLOADED DOCUMENTS</div>
        <table class="document-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Document Type</th>
                    <th style="width: 45%;">File Name</th>
                    <th style="width: 30%;">Upload Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profile->uploads as $upload)
                <tr>
                    <td>{{ $upload->type }}</td>
                    <td>{{ $upload->file_name }}</td>
                    <td>{{ $upload->created_at->format('F d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>V-PeSDI PLWDs Database System</strong></p>
        <p>This is an official document generated from the database on {{ $generatedDate }}</p>
        <p>© {{ date('Y') }} V-PeSDI PLWDs Database. All rights reserved.</p>
    </div>
</body>
</html>
