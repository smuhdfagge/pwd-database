@extends('layouts.app')

@section('title', 'Manage Disability Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Disability Types</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDisabilityTypeModal">
        <i class="fas fa-plus"></i> Add New Type
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
        @if($disabilityTypes->count() > 0)
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
                        @foreach($disabilityTypes as $type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $type->name }}</strong></td>
                                <td>{{ $type->description ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $type->plwd_profiles_count }} PLWDs</span>
                                </td>
                                <td>{{ $type->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editDisabilityTypeModal{{ $type->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    @if($type->plwd_profiles_count == 0)
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteDisabilityTypeModal{{ $type->id }}">
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
                            <div class="modal fade" id="editDisabilityTypeModal{{ $type->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.disability-types.update', $type->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Disability Type</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit_name{{ $type->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name{{ $type->id }}" 
                                                           name="name" value="{{ $type->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_description{{ $type->id }}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="edit_description{{ $type->id }}" 
                                                              name="description" rows="3">{{ $type->description }}</textarea>
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
                            @if($type->plwd_profiles_count == 0)
                                <div class="modal fade" id="deleteDisabilityTypeModal{{ $type->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.disability-types.destroy', $type->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Disability Type</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>{{ $type->name }}</strong>?</p>
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
                    Showing {{ $disabilityTypes->firstItem() ?? 0 }} to {{ $disabilityTypes->lastItem() ?? 0 }} 
                    of {{ $disabilityTypes->total() }} entries
                </div>
                <div>
                    {{ $disabilityTypes->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-list fa-3x text-muted mb-3"></i>
                <p class="text-muted">No disability types found. Click "Add New Type" to create one.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDisabilityTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.disability-types.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Disability Type</h5>
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
                    <button type="submit" class="btn btn-success">Add Disability Type</button>
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
        var addModal = new bootstrap.Modal(document.getElementById('addDisabilityTypeModal'));
        addModal.show();
    @endif
</script>
@endsection
