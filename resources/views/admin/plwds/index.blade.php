@extends('layouts.app')

@section('title', 'Manage PLWDs')

@section('content')
<h2 class="mb-4">Manage PLWDs</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.plwds.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name or Email" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">State</label>
                            <select name="state" class="form-select">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Disability Type</label>
                            <select name="disability_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($disabilityTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('disability_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">All Genders</option>
                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="verified" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
                                <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.plwds.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PLWDs Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Registered PLWDs ({{ $plwds->total() }})</h5>
                    <div>
                        <a href="{{ route('admin.export.excel', request()->all()) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>State/LGA</th>
                                    <th>Disability Type</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plwds as $profile)
                                    <tr>
                                        <td>{{ $profile->id }}</td>
                                        <td>{{ $profile->user->name }}</td>
                                        <td>{{ $profile->user->email }}</td>
                                        <td>{{ $profile->gender }}</td>
                                        <td>{{ $profile->state }}/{{ $profile->lga }}</td>
                                        <td>{{ $profile->disabilityType?->name }}</td>
                                        <td>
                                            @if($profile->verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $profile->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.plwds.show', $profile->id) }}" class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$profile->verified)
                                                    <form action="{{ route('admin.plwds.approve', $profile->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" title="Approve" onclick="return confirm('Approve this profile?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <button type="button" class="btn btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $profile->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $profile->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <strong>{{ $profile->user->name }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.plwds.destroy', $profile->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No PLWDs found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $plwds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
