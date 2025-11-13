@extends('layouts.app')

@section('title', 'Manage Opportunities - V-PeSDI PLWDs Database')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Opportunities</h2>
    <a href="{{ route('admin.opportunities.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Opportunity
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($opportunities->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Organization</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($opportunities as $opportunity)
                            <tr>
                                <td>
                                    <strong>{{ $opportunity->title }}</strong>
                                </td>
                                <td>{{ $opportunity->organization ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($opportunity->type) }}
                                    </span>
                                </td>
                                <td>{{ $opportunity->location ?? 'N/A' }}</td>
                                <td>
                                    @if($opportunity->deadline)
                                        {{ $opportunity->deadline->format('M d, Y') }}
                                        @if($opportunity->isExpired())
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No deadline</span>
                                    @endif
                                </td>
                                <td>
                                    @if($opportunity->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($opportunity->status === 'inactive')
                                        <span class="badge bg-warning">Inactive</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td>
                                <td>{{ $opportunity->views }}</td>
                                <td>
                                    <a href="{{ route('admin.opportunities.edit', $opportunity->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.opportunities.destroy', $opportunity->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this opportunity?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $opportunities->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <p class="text-muted">No opportunities found.</p>
                <a href="{{ route('admin.opportunities.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create First Opportunity
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
