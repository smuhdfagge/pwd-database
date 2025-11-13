@extends('layouts.app')

@section('title', 'Dashboard - V-PeSDI PLWDs Database')

@section('content')
<h2 class="mb-4">Welcome, {{ $user->name }}!</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Profile Status -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Profile Status</h6>
                            @if($profile && $profile->verified)
                                <h4><span class="badge bg-success">Verified</span></h4>
                            @elseif($profile)
                                <h4><span class="badge bg-warning">Pending Verification</span></h4>
                            @else
                                <h4><span class="badge bg-secondary">Incomplete</span></h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Profile Completion</h6>
                            <h4>{{ $profile ? '100%' : '20%' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Documents Uploaded</h6>
                            <h4>{{ $profile ? $profile->uploads->count() : 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$profile)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Action Required:</strong> Please complete your profile to get verified.
                    <a href="{{ route('plwd.profile.edit') }}" class="alert-link">Complete Profile Now</a>
                </div>
            @endif

            <!-- Profile Details -->
            @if($profile)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                @if($profile->photo)
                                    <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Full Name:</strong> {{ $user->name }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Gender:</strong> {{ $profile->gender }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Date of Birth:</strong> {{ $profile->date_of_birth?->format('d M Y') }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Phone:</strong> {{ $profile->phone }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>State:</strong> {{ $profile->state }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>LGA:</strong> {{ $profile->lga }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Disability Type:</strong> {{ $profile->disabilityType?->name }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Education Level:</strong> {{ $profile->educationLevel?->name }}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <strong>Address:</strong> {{ $profile->address }}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <strong>Skills:</strong><br>
                                        @if(isset($profile->skillsData) && $profile->skillsData->count() > 0)
                                            @foreach($profile->skillsData as $skill)
                                                <span class="badge bg-success me-1 mb-1">{{ $skill->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No skills selected</span>
                                        @endif
                                    </div>
                                    @if($profile->bio)
                                        <div class="col-md-12 mb-3">
                                            <strong>Bio:</strong><br>
                                            {{ $profile->bio }}
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('plwd.profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                                <a href="{{ route('plwd.profile.download-pdf') }}" class="btn btn-success">
                                    <i class="fas fa-file-pdf"></i> Download my Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Information Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Educational Information</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->educationRecords && $profile->educationRecords->count() > 0)
                            <div class="row">
                                @foreach($profile->educationRecords as $record)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border">
                                            <div class="card-body">
                                                <h6 class="card-title mb-3">
                                                    @if($record->educationLevel)
                                                        <i class="fas fa-certificate text-primary"></i> {{ $record->educationLevel->name }}
                                                    @else
                                                        <i class="fas fa-certificate text-muted"></i> Education Record
                                                    @endif
                                                </h6>
                                                
                                                @if($record->institution)
                                                    <p class="mb-1"><strong>Institution:</strong> {{ $record->institution }}</p>
                                                @endif
                                                
                                                @if($record->from_year || $record->to_year)
                                                    <p class="mb-1">
                                                        <strong>Period:</strong> 
                                                        {{ $record->from_year ?? 'N/A' }} - {{ $record->to_year ?? 'Present' }}
                                                    </p>
                                                @endif
                                                
                                                @if($record->certificate_obtained)
                                                    <p class="mb-1"><strong>Certificate:</strong> {{ $record->certificate_obtained }}</p>
                                                @endif
                                                
                                                @if($record->document_path)
                                                    <p class="mb-0 mt-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#eduDocModal{{ $record->id }}">
                                                            <i class="fas fa-file-pdf"></i> View Document
                                                        </button>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Education Document Modal -->
                                    @if($record->document_path)
                                        <div class="modal fade" id="eduDocModal{{ $record->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-graduation-cap"></i> 
                                                            {{ $record->certificate_obtained ?? 'Education Document' }}
                                                            @if($record->institution)
                                                                - {{ $record->institution }}
                                                            @endif
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $extension = strtolower(pathinfo($record->document_path, PATHINFO_EXTENSION));
                                                        @endphp
                                                        
                                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/' . $record->document_path) }}" class="img-fluid" alt="Education Certificate">
                                                        @elseif($extension == 'pdf')
                                                            <iframe src="{{ asset('storage/' . $record->document_path) }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
                                                        @else
                                                            <p class="text-center">
                                                                <i class="fas fa-file fa-3x mb-3"></i><br>
                                                                Preview not available for this file type.<br>
                                                                <a href="{{ asset('storage/' . $record->document_path) }}" download class="btn btn-primary mt-3">
                                                                    <i class="fas fa-download"></i> Download File
                                                                </a>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ asset('storage/' . $record->document_path) }}" download class="btn btn-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No educational records added yet.</p>
                        @endif
                        <a href="{{ route('plwd.profile.edit') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus"></i> Add/Edit Educational Information
                        </a>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="card" id="documents">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-file"></i> Uploaded Documents</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-plus"></i> Upload Document
                        </button>
                    </div>
                    <div class="card-body">
                        @if($profile->uploads->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>File Name</th>
                                            <th>Upload Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profile->uploads as $upload)
                                            <tr>
                                                <td>{{ $upload->type }}</td>
                                                <td>{{ $upload->file_name }}</td>
                                                <td>{{ $upload->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewDocModal{{ $upload->id }}">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                    <a href="{{ asset('storage/' . $upload->file_path) }}" download class="btn btn-sm btn-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                    <form action="{{ route('plwd.documents.delete', $upload->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
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
            @endif

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('plwd.documents.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Document Type *</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="ID Card">ID Card</option>
                            <option value="Medical Report">Medical Report</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="document" class="form-label">Document File (Max: 5MB) *</label>
                        <input type="file" name="document" id="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
