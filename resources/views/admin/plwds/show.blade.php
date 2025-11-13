@extends('layouts.app')

@section('title', 'PLWD Profile Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>PLWD Profile Details</h2>
    <a href="{{ route('admin.plwds.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

@if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Profile Info Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Personal Information</h5>
                    <div>
                        @if($profile->verified)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-warning">Pending Verification</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            @if($profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="img-fluid rounded-circle" style="max-width: 200px;">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Full Name:</strong><br>{{ $profile->user->name }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Email:</strong><br>{{ $profile->user->email }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Gender:</strong><br>{{ $profile->gender }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Date of Birth:</strong><br>{{ $profile->date_of_birth?->format('d M Y') }} ({{ $profile->age }} years)
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Phone:</strong><br>{{ $profile->phone }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>State:</strong><br>{{ $profile->state }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>LGA:</strong><br>{{ $profile->lga }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Disability Type:</strong><br>{{ $profile->disabilityType?->name }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Education Level:</strong><br>{{ $profile->educationLevel?->name }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Registration Date:</strong><br>{{ $profile->created_at->format('d M Y') }}
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Address:</strong><br>{{ $profile->address }}
                                </div>
                                @if($profile->skills && count($profile->skills) > 0)
                                    <div class="col-md-12 mb-3">
                                        <strong>Skills:</strong><br>
                                        @foreach($profile->skills as $skill)
                                            <span class="badge bg-info me-1">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if($profile->bio)
                                    <div class="col-md-12 mb-3">
                                        <strong>Bio:</strong><br>
                                        <p>{{ $profile->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file"></i> Uploaded Documents ({{ $profile->uploads->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($profile->uploads->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>File Name</th>
                                        <th>Size</th>
                                        <th>Upload Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profile->uploads as $upload)
                                        <tr>
                                            <td>{{ $upload->type }}</td>
                                            <td>{{ $upload->file_name }}</td>
                                            <td>{{ number_format($upload->file_size / 1024, 2) }} KB</td>
                                            <td>{{ $upload->created_at->format('d M Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewDocModal{{ $upload->id }}">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                                <a href="{{ asset('storage/' . $upload->file_path) }}" download class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- View Document Modal -->
                                        <div class="modal fade" id="viewDocModal{{ $upload->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $upload->type }} - {{ $upload->file_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $extension = strtolower(pathinfo($upload->file_name, PATHINFO_EXTENSION));
                                                        @endphp
                                                        
                                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/' . $upload->file_path) }}" class="img-fluid" alt="{{ $upload->file_name }}">
                                                        @elseif($extension == 'pdf')
                                                            <iframe src="{{ asset('storage/' . $upload->file_path) }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
                                                        @else
                                                            <p class="text-center">
                                                                <i class="fas fa-file fa-3x mb-3"></i><br>
                                                                Preview not available for this file type.<br>
                                                                <a href="{{ asset('storage/' . $upload->file_path) }}" download class="btn btn-primary mt-3">
                                                                    <i class="fas fa-download"></i> Download File
                                                                </a>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ asset('storage/' . $upload->file_path) }}" download class="btn btn-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No documents uploaded yet.</p>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cog"></i> Administrative Actions</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        @if(!$profile->verified)
                            <form action="{{ route('admin.plwds.approve', $profile->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Approve this profile?')">
                                    <i class="fas fa-check-circle"></i> Approve Profile
                                </button>
                            </form>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times-circle"></i> Reject Profile
                            </button>
                        @else
                            <button class="btn btn-success" disabled>
                                <i class="fas fa-check-circle"></i> Already Verified
                            </button>
                        @endif
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Delete Profile
                        </button>
                    </div>
                </div>
            </div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.plwds.reject', $profile->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Rejection (Optional)</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Reject Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $profile->user->name }}</strong>'s profile?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.plwds.destroy', $profile->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
