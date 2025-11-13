@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar"></i> Reports & Analytics</h2>
    <div>
        <a href="{{ route('admin.export.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export to Excel
        </a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export to PDF
        </a>
    </div>
</div>

<!-- Summary Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <h6>Total Registered PLWDs</h6>
                <h2>{{ $totalPlwds }}</h2>
                <small><i class="fas fa-users"></i> All registrations</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <h6>Verified PLWDs</h6>
                <h2>{{ $verifiedPlwds }}</h2>
                <small><i class="fas fa-check-circle"></i> {{ $totalPlwds > 0 ? round(($verifiedPlwds / $totalPlwds) * 100, 1) : 0 }}% of total</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <h6>Pending Verification</h6>
                <h2>{{ $pendingPlwds }}</h2>
                <small><i class="fas fa-clock"></i> Awaiting approval</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="row mb-4">
    <!-- PLWDs by Disability Type -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-list"></i> Distribution by Disability Type</h5>
            </div>
            <div class="card-body">
                @if($plwdsByDisability->count() > 0)
                    <div style="position: relative; height: 300px;">
                        <canvas id="disabilityChart"></canvas>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Disability Type</th>
                                    <th class="text-end">Count</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plwdsByDisability as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-end">{{ $item['count'] }}</td>
                                        <td class="text-end">{{ $totalPlwds > 0 ? round(($item['count'] / $totalPlwds) * 100, 1) : 0 }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- PLWDs by Education Level -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Distribution by Education Level</h5>
            </div>
            <div class="card-body">
                @if($plwdsByEducation->count() > 0)
                    <div style="position: relative; height: 300px;">
                        <canvas id="educationChart"></canvas>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Education Level</th>
                                    <th class="text-end">Count</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plwdsByEducation as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-end">{{ $item['count'] }}</td>
                                        <td class="text-end">{{ $totalPlwds > 0 ? round(($item['count'] / $totalPlwds) * 100, 1) : 0 }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="row mb-4">
    <!-- PLWDs by Gender -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-venus-mars"></i> Distribution by Gender</h5>
            </div>
            <div class="card-body">
                @if($plwdsByGender->count() > 0)
                    <div style="position: relative; height: 300px;">
                        <canvas id="genderChart"></canvas>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Gender</th>
                                    <th class="text-end">Count</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plwdsByGender as $item)
                                    <tr>
                                        <td>{{ $item->gender ?? 'Not Specified' }}</td>
                                        <td class="text-end">{{ $item->count }}</td>
                                        <td class="text-end">{{ $totalPlwds > 0 ? round(($item->count / $totalPlwds) * 100, 1) : 0 }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Monthly Registration Trend -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Monthly Registration Trend (Last 12 Months)</h5>
            </div>
            <div class="card-body">
                @if($monthlyRegistrations->count() > 0)
                    <div style="position: relative; height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- PLWDs by State -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Distribution by State</h5>
            </div>
            <div class="card-body">
                @if($plwdsByState->count() > 0)
                    <div class="row">
                        <div class="col-md-8">
                            <div style="position: relative; height: 400px;">
                                <canvas id="stateChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-sm">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            <th>State</th>
                                            <th class="text-end">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plwdsByState as $item)
                                            <tr>
                                                <td>{{ $item->state }}</td>
                                                <td class="text-end"><strong>{{ $item->count }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Registrations -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Recent Registrations (Last 10)</h5>
            </div>
            <div class="card-body">
                @if($recentRegistrations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Disability Type</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRegistrations as $profile)
                                    <tr>
                                        <td>{{ $profile->user->name }}</td>
                                        <td>{{ $profile->user->email }}</td>
                                        <td>{{ $profile->disabilityType->name ?? 'N/A' }}</td>
                                        <td>{{ $profile->state ?? 'N/A' }}</td>
                                        <td>
                                            @if($profile->verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $profile->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No recent registrations</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Color palette
    const colors = [
        'rgba(40, 167, 69, 0.8)',    // Green
        'rgba(0, 123, 255, 0.8)',    // Blue
        'rgba(255, 193, 7, 0.8)',    // Yellow
        'rgba(220, 53, 69, 0.8)',    // Red
        'rgba(23, 162, 184, 0.8)',   // Cyan
        'rgba(108, 117, 125, 0.8)',  // Gray
        'rgba(255, 87, 34, 0.8)',    // Orange
        'rgba(156, 39, 176, 0.8)',   // Purple
        'rgba(233, 30, 99, 0.8)',    // Pink
        'rgba(0, 188, 212, 0.8)',    // Light Blue
    ];

    // Disability Type Chart
    @if($plwdsByDisability->count() > 0)
    new Chart(document.getElementById('disabilityChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($plwdsByDisability->pluck('name')->values()) !!},
            datasets: [{
                data: {!! json_encode($plwdsByDisability->pluck('count')->values()) !!},
                backgroundColor: colors,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    @endif

    // Education Level Chart
    @if($plwdsByEducation->count() > 0)
    new Chart(document.getElementById('educationChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($plwdsByEducation->pluck('name')->values()) !!},
            datasets: [{
                label: 'PLWDs',
                data: {!! json_encode($plwdsByEducation->pluck('count')->values()) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    @endif

    // Gender Chart
    @if($plwdsByGender->count() > 0)
    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($plwdsByGender->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($plwdsByGender->pluck('count')) !!},
                backgroundColor: [
                    'rgba(0, 123, 255, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(108, 117, 125, 0.8)',
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    @endif

    // Monthly Trend Chart
    @if($monthlyRegistrations->count() > 0)
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRegistrations->pluck('month')) !!},
            datasets: [{
                label: 'Registrations',
                data: {!! json_encode($monthlyRegistrations->pluck('count')) !!},
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    @endif

    // State Chart (Top 15)
    @if($plwdsByState->count() > 0)
    new Chart(document.getElementById('stateChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($plwdsByState->take(15)->pluck('state')) !!},
            datasets: [{
                label: 'PLWDs',
                data: {!! json_encode($plwdsByState->take(15)->pluck('count')) !!},
                backgroundColor: 'rgba(0, 123, 255, 0.8)',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.2,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    @endif
</script>
@endsection
