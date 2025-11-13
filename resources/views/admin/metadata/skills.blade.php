@extends('layouts.app')

@section('title', 'Manage Skills')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Skills</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSkillModal">
        <i class="fas fa-plus"></i> Add New Skill
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
        @if($skills->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $skill->name }}</strong></td>
                                <td>{{ $skill->description ?? 'N/A' }}</td>
                                <td>{{ $skill->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSkillModal{{ $skill->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteSkillModal{{ $skill->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editSkillModal{{ $skill->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.skills.update', $skill->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Skill</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit_name{{ $skill->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name{{ $skill->id }}" 
                                                           name="name" value="{{ $skill->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_description{{ $skill->id }}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="edit_description{{ $skill->id }}" 
                                                              name="description" rows="3">{{ $skill->description }}</textarea>
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
                            <div class="modal fade" id="deleteSkillModal{{ $skill->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Skill</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete <strong>{{ $skill->name }}</strong>?</p>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $skills->firstItem() ?? 0 }} to {{ $skills->lastItem() ?? 0 }} 
                    of {{ $skills->total() }} entries
                </div>
                <div>
                    {{ $skills->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                <p class="text-muted">No skills found. Click "Add New Skill" to create one.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSkillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.skills.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Skill</h5>
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
                    <button type="submit" class="btn btn-success">Add Skill</button>
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
        var addModal = new bootstrap.Modal(document.getElementById('addSkillModal'));
        addModal.show();
    @endif
</script>
@endsection
