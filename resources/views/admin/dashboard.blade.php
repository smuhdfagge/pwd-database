@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h2 class="mb-4">Admin Dashboard</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <h6>Total Registered Users</h6>
                            <h2>{{ $totalUsers }}</h2>
                            <small><i class="fas fa-users"></i> All Users</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <h6>Completed Profiles</h6>
                            <h2>{{ $totalPlwds }}</h2>
                            <small><i class="fas fa-user-check"></i> With Profiles</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-warning text-white">
                        <div class="card-body">
                            <h6>Incomplete Profiles</h6>
                            <h2>{{ $usersWithoutProfile }}</h2>
                            <small><i class="fas fa-exclamation-triangle"></i> Needs Attention</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <h6>Verified PLWDs</h6>
                            <h2>{{ $verifiedPlwds }}</h2>
                            <small><i class="fas fa-check-circle"></i> Approved</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert for users without profiles -->
            @if($usersWithoutProfile > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> 
                <strong>Attention!</strong> There are <strong>{{ $usersWithoutProfile }}</strong> registered user(s) who have not completed their profile yet.
                <a href="{{ route('admin.users.index') }}?has_profile=no" class="alert-link">View them here</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- By Disability Type -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> PLWDs by Disability Type</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Disability Type</th>
                                            <th class="text-end">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plwdsByDisability as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td class="text-end"><strong>{{ $item['count'] }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- By Gender -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> PLWDs by Gender</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Gender</th>
                                            <th class="text-end">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plwdsByGender as $item)
                                            <tr>
                                                <td>{{ $item->gender }}</td>
                                                <td class="text-end"><strong>{{ $item->count }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- By Education Level -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> PLWDs by Education Level</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Education Level</th>
                                            <th class="text-end">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plwdsByEducation as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td class="text-end"><strong>{{ $item['count'] }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- By State (Top 10) -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Top 10 States</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
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
                </div>
            </div>

            <!-- Recent Registrations -->
            <div class="row mb-4">
                <!-- Users Without Profile -->
                @if($recentUsersWithoutProfile->count() > 0)
                <div class="col-md-6 mb-3">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-user-times"></i> Users Without Profile</h5>
                            <a href="{{ route('admin.users.index') }}?has_profile=no" class="btn btn-sm btn-dark">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentUsersWithoutProfile as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Completed Profiles -->
                <div class="col-md-{{ $recentUsersWithoutProfile->count() > 0 ? '6' : '12' }} mb-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clock"></i> Recent Completed Profiles</h5>
                            <a href="{{ route('admin.plwds.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>State</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentRegistrations as $profile)
                                            <tr>
                                                <td>{{ $profile->user->name }}</td>
                                                <td>{{ $profile->user->email }}</td>
                                                <td>{{ $profile->state }}</td>
                                                <td>
                                                    @if($profile->verified)
                                                        <span class="badge bg-success">Verified</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $profile->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.plwds.show', $profile->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No recent profiles</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
