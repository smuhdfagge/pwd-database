@extends('layouts.app')

@section('title', 'Manage Education Levels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Education Levels</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEducationLevelModal">
        <i class="fas fa-plus"></i> Add New Level
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($educationLevels->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>PLWDs Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($educationLevels as $level)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $level->name }}</strong></td>
                                <td>{{ $level->description ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $level->plwd_profiles_count }} PLWDs</span>
                                </td>
                                <td>{{ $level->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editEducationLevelModal{{ $level->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    @if($level->plwd_profiles_count == 0)
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteEducationLevelModal{{ $level->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-secondary" disabled title="Cannot delete: has associated PLWDs">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editEducationLevelModal{{ $level->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.education-levels.update', $level->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Education Level</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit_name{{ $level->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name{{ $level->id }}" 
                                                           name="name" value="{{ $level->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_description{{ $level->id }}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="edit_description{{ $level->id }}" 
                                                              name="description" rows="3">{{ $level->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            @if($level->plwd_profiles_count == 0)
                                <div class="modal fade" id="deleteEducationLevelModal{{ $level->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.education-levels.destroy', $level->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Education Level</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>{{ $level->name }}</strong>?</p>
                                                    <p class="text-danger">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $educationLevels->firstItem() ?? 0 }} to {{ $educationLevels->lastItem() ?? 0 }} 
                    of {{ $educationLevels->total() }} entries
                </div>
                <div>
                    {{ $educationLevels->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                <p class="text-muted">No education levels found. Click "Add New Level" to create one.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addEducationLevelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.education-levels.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Education Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Education Level</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Reopen modal if there are validation errors
    @if($errors->any() && old('_token'))
        var addModal = new bootstrap.Modal(document.getElementById('addEducationLevelModal'));
        addModal.show();
    @endif
</script>
@endsection
