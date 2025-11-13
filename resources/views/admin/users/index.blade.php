@extends('layouts.app')

@section('title', 'All Registered Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Registered Users</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name or Email" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Profile Status</label>
                    <select name="has_profile" class="form-select">
                        <option value="">All Users</option>
                        <option value="yes" {{ request('has_profile') == 'yes' ? 'selected' : '' }}>With Profile</option>
                        <option value="no" {{ request('has_profile') == 'no' ? 'selected' : '' }}>Without Profile</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Registered Users ({{ $users->total() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Profile Status</th>
                            <th>Registered Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->plwdProfile)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Profile Completed
                                        </span>
                                        @if($user->plwdProfile->verified)
                                            <span class="badge bg-info">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Pending Verification</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-exclamation-triangle"></i> No Profile
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($user->plwdProfile)
                                        <a href="{{ route('admin.plwds.show', $user->plwdProfile->id) }}" class="btn btn-sm btn-info" title="View Profile">
                                            <i class="fas fa-eye"></i> View Profile
                                        </a>
                                    @else
                                        <span class="text-muted small">
                                            <i class="fas fa-info-circle"></i> Waiting for profile
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="alert alert-info mt-3">
        <i class="fas fa-info-circle"></i> 
        <strong>Note:</strong> Users appear here immediately after registration. However, they need to complete their profile 
        to be included in the PLWD directory. Users without profiles are shown with a red badge.
    </div>
</div>
@endsection
