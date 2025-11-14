@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h4>
            @if($profile->exists)
                <div class="text-end">
                    <span class="badge 
                        @if($profile->profile_completion >= 80) bg-success
                        @elseif($profile->profile_completion >= 50) bg-info
                        @elseif($profile->profile_completion >= 30) bg-warning
                        @else bg-danger
                        @endif" style="font-size: 1rem;">
                        {{ $profile->profile_completion }}% Complete
                    </span>
                    <br>
                    <small class="text-muted">{{ $profile->completed_required_fields }}/{{ $profile->total_required_fields }} required fields</small>
                </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if($profile->exists && !$profile->is_complete)
            <div class="alert alert-info mb-3">
                <strong><i class="fas fa-info-circle"></i> Complete your profile:</strong>
                @if(count($profile->missing_required_fields) > 0)
                    <br><small><strong>Required:</strong> {{ implode(', ', $profile->missing_required_fields) }}</small>
                @endif
                @if(count($profile->missing_optional_fields) > 0)
                    <br><small><strong>Optional:</strong> {{ implode(', ', $profile->missing_optional_fields) }}</small>
                @endif
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('plwd.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Photo Upload -->
                            <div class="col-md-12 mb-4 text-center">
                                @if($profile->photo)
                                    <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x"></i>
                                    </div>
                                @endif
                                <div>
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                                    <small class="text-muted">Max size: 2MB</small>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $profile->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $profile->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $profile->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="e.g., 08012345678" required>
                            </div>

                            <!-- State -->
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <select name="state" id="state" class="form-select" required>
                                    <option value="">Select State</option>
                                    <option value="Abia" {{ old('state', $profile->state) == 'Abia' ? 'selected' : '' }}>Abia</option>
                                    <option value="Adamawa" {{ old('state', $profile->state) == 'Adamawa' ? 'selected' : '' }}>Adamawa</option>
                                    <option value="Akwa Ibom" {{ old('state', $profile->state) == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                    <option value="Anambra" {{ old('state', $profile->state) == 'Anambra' ? 'selected' : '' }}>Anambra</option>
                                    <option value="Bauchi" {{ old('state', $profile->state) == 'Bauchi' ? 'selected' : '' }}>Bauchi</option>
                                    <option value="Bayelsa" {{ old('state', $profile->state) == 'Bayelsa' ? 'selected' : '' }}>Bayelsa</option>
                                    <option value="Benue" {{ old('state', $profile->state) == 'Benue' ? 'selected' : '' }}>Benue</option>
                                    <option value="Borno" {{ old('state', $profile->state) == 'Borno' ? 'selected' : '' }}>Borno</option>
                                    <option value="Cross River" {{ old('state', $profile->state) == 'Cross River' ? 'selected' : '' }}>Cross River</option>
                                    <option value="Delta" {{ old('state', $profile->state) == 'Delta' ? 'selected' : '' }}>Delta</option>
                                    <option value="Ebonyi" {{ old('state', $profile->state) == 'Ebonyi' ? 'selected' : '' }}>Ebonyi</option>
                                    <option value="Edo" {{ old('state', $profile->state) == 'Edo' ? 'selected' : '' }}>Edo</option>
                                    <option value="Ekiti" {{ old('state', $profile->state) == 'Ekiti' ? 'selected' : '' }}>Ekiti</option>
                                    <option value="Enugu" {{ old('state', $profile->state) == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                                    <option value="FCT" {{ old('state', $profile->state) == 'FCT' ? 'selected' : '' }}>FCT</option>
                                    <option value="Gombe" {{ old('state', $profile->state) == 'Gombe' ? 'selected' : '' }}>Gombe</option>
                                    <option value="Imo" {{ old('state', $profile->state) == 'Imo' ? 'selected' : '' }}>Imo</option>
                                    <option value="Jigawa" {{ old('state', $profile->state) == 'Jigawa' ? 'selected' : '' }}>Jigawa</option>
                                    <option value="Kaduna" {{ old('state', $profile->state) == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <option value="Kano" {{ old('state', $profile->state) == 'Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Katsina" {{ old('state', $profile->state) == 'Katsina' ? 'selected' : '' }}>Katsina</option>
                                    <option value="Kebbi" {{ old('state', $profile->state) == 'Kebbi' ? 'selected' : '' }}>Kebbi</option>
                                    <option value="Kogi" {{ old('state', $profile->state) == 'Kogi' ? 'selected' : '' }}>Kogi</option>
                                    <option value="Kwara" {{ old('state', $profile->state) == 'Kwara' ? 'selected' : '' }}>Kwara</option>
                                    <option value="Lagos" {{ old('state', $profile->state) == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Nasarawa" {{ old('state', $profile->state) == 'Nasarawa' ? 'selected' : '' }}>Nasarawa</option>
                                    <option value="Niger" {{ old('state', $profile->state) == 'Niger' ? 'selected' : '' }}>Niger</option>
                                    <option value="Ogun" {{ old('state', $profile->state) == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                                    <option value="Ondo" {{ old('state', $profile->state) == 'Ondo' ? 'selected' : '' }}>Ondo</option>
                                    <option value="Osun" {{ old('state', $profile->state) == 'Osun' ? 'selected' : '' }}>Osun</option>
                                    <option value="Oyo" {{ old('state', $profile->state) == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Plateau" {{ old('state', $profile->state) == 'Plateau' ? 'selected' : '' }}>Plateau</option>
                                    <option value="Rivers" {{ old('state', $profile->state) == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Sokoto" {{ old('state', $profile->state) == 'Sokoto' ? 'selected' : '' }}>Sokoto</option>
                                    <option value="Taraba" {{ old('state', $profile->state) == 'Taraba' ? 'selected' : '' }}>Taraba</option>
                                    <option value="Yobe" {{ old('state', $profile->state) == 'Yobe' ? 'selected' : '' }}>Yobe</option>
                                    <option value="Zamfara" {{ old('state', $profile->state) == 'Zamfara' ? 'selected' : '' }}>Zamfara</option>
                                </select>
                            </div>

                            <!-- LGA -->
                            <div class="col-md-6 mb-3">
                                <label for="lga" class="form-label">Local Government Area (LGA) *</label>
                                <input type="text" name="lga" id="lga" class="form-control" value="{{ old('lga', $profile->lga) }}" required>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address *</label>
                                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $profile->address) }}</textarea>
                            </div>

                            <!-- Disability Type -->
                            <div class="col-md-6 mb-3">
                                <label for="disability_type_id" class="form-label">Disability Type *</label>
                                <select name="disability_type_id" id="disability_type_id" class="form-select" required>
                                    <option value="">Select Disability Type</option>
                                    @foreach($disabilityTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('disability_type_id', $profile->disability_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Education Level -->
                            <div class="col-md-6 mb-3">
                                <label for="education_level_id" class="form-label">Highest Education Level *</label>
                                <select name="education_level_id" id="education_level_id" class="form-select" required>
                                    <option value="">Select Education Level</option>
                                    @foreach($educationLevels as $level)
                                        <option value="{{ $level->id }}" {{ old('education_level_id', $profile->education_level_id) == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Skills -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Skills (Select all that apply)</label>
                                <div class="row">
                                    @foreach($skills as $skill)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="skills[]" value="{{ $skill->name }}" id="skill_{{ $skill->id }}" class="form-check-input"
                                                    {{ in_array($skill->name, old('skills', $profile->skills ?? [])) ? 'checked' : '' }}>
                                                <label for="skill_{{ $skill->id }}" class="form-check-label">{{ $skill->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Educational Information Section -->
                            <div class="col-md-12 mb-4">
                                <hr class="my-4">
                                <h5 class="mb-3"><i class="fas fa-graduation-cap"></i> Educational Information</h5>
                                <p class="text-muted small mb-3">Add your educational background and qualifications</p>
                                
                                <div id="education-records-container">
                                    @if($educationRecords && $educationRecords->count() > 0)
                                        @foreach($educationRecords as $index => $record)
                                            <div class="education-record-item card mb-3" data-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0">Education Record #{{ $index + 1 }}</h6>
                                                        <button type="button" class="btn btn-sm btn-danger remove-education-record" data-id="{{ $record->id }}">
                                                            <i class="fas fa-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                    
                                                    <input type="hidden" name="education_records[{{ $index }}][id]" value="{{ $record->id }}">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Education Level</label>
                                                            <select name="education_records[{{ $index }}][education_level_id]" class="form-select">
                                                                <option value="">Select Education Level</option>
                                                                @foreach($educationLevels as $level)
                                                                    <option value="{{ $level->id }}" {{ $record->education_level_id == $level->id ? 'selected' : '' }}>
                                                                        {{ $level->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Institution</label>
                                                            <input type="text" name="education_records[{{ $index }}][institution]" class="form-control" 
                                                                   value="{{ old('education_records.'.$index.'.institution', $record->institution) }}" 
                                                                   placeholder="e.g., University of Lagos">
                                                        </div>
                                                        
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">From Year</label>
                                                            <input type="number" name="education_records[{{ $index }}][from_year]" class="form-control" 
                                                                   value="{{ old('education_records.'.$index.'.from_year', $record->from_year) }}" 
                                                                   placeholder="e.g., 2015" min="1950" max="{{ date('Y') }}">
                                                        </div>
                                                        
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">To Year</label>
                                                            <input type="number" name="education_records[{{ $index }}][to_year]" class="form-control" 
                                                                   value="{{ old('education_records.'.$index.'.to_year', $record->to_year) }}" 
                                                                   placeholder="e.g., 2019" min="1950" max="{{ date('Y') + 10 }}">
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Certificate Obtained</label>
                                                            <input type="text" name="education_records[{{ $index }}][certificate_obtained]" class="form-control" 
                                                                   value="{{ old('education_records.'.$index.'.certificate_obtained', $record->certificate_obtained) }}" 
                                                                   placeholder="e.g., Bachelor of Science">
                                                        </div>
                                                        
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Upload Certificate/Document</label>
                                                            <input type="file" name="education_records[{{ $index }}][document]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                            @if($record->document_path)
                                                                <small class="text-success d-block mt-1">
                                                                    <i class="fas fa-check-circle"></i> Document uploaded: 
                                                                    <a href="{{ asset('storage/' . $record->document_path) }}" target="_blank">View</a>
                                                                </small>
                                                            @endif
                                                            <small class="text-muted d-block">Accepted formats: PDF, JPG, PNG (Max: 5MB)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                
                                <button type="button" class="btn btn-outline-primary" id="add-education-record">
                                    <i class="fas fa-plus"></i> Add Education Record
                                </button>
                            </div>

                            <!-- Bio -->
                            <div class="col-md-12 mb-3">
                                <label for="bio" class="form-label">Personal Bio (Optional)</label>
                                <textarea name="bio" id="bio" class="form-control" rows="4" maxlength="1000" placeholder="Tell us about yourself...">{{ old('bio', $profile->bio) }}</textarea>
                                <small class="text-muted">Maximum 1000 characters</small>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Profile
                                </button>
                                <a href="{{ route('plwd.dashboard') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let educationRecordIndex = {{ $educationRecords ? $educationRecords->count() : 0 }};
    
    // Add new education record
    document.getElementById('add-education-record').addEventListener('click', function() {
        const container = document.getElementById('education-records-container');
        const newRecord = `
            <div class="education-record-item card mb-3" data-index="${educationRecordIndex}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Education Record #${educationRecordIndex + 1}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-education-record-new">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Education Level</label>
                            <select name="education_records[${educationRecordIndex}][education_level_id]" class="form-select">
                                <option value="">Select Education Level</option>
                                @foreach($educationLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Institution</label>
                            <input type="text" name="education_records[${educationRecordIndex}][institution]" class="form-control" 
                                   placeholder="e.g., University of Lagos">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">From Year</label>
                            <input type="number" name="education_records[${educationRecordIndex}][from_year]" class="form-control" 
                                   placeholder="e.g., 2015" min="1950" max="{{ date('Y') }}">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">To Year</label>
                            <input type="number" name="education_records[${educationRecordIndex}][to_year]" class="form-control" 
                                   placeholder="e.g., 2019" min="1950" max="{{ date('Y') + 10 }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Certificate Obtained</label>
                            <input type="text" name="education_records[${educationRecordIndex}][certificate_obtained]" class="form-control" 
                                   placeholder="e.g., Bachelor of Science">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Certificate/Document</label>
                            <input type="file" name="education_records[${educationRecordIndex}][document]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted d-block">Accepted formats: PDF, JPG, PNG (Max: 5MB)</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newRecord);
        educationRecordIndex++;
    });
    
    // Remove new education record (not yet saved)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education-record-new') || 
            e.target.closest('.remove-education-record-new')) {
            const button = e.target.classList.contains('remove-education-record-new') ? 
                          e.target : e.target.closest('.remove-education-record-new');
            const recordItem = button.closest('.education-record-item');
            if (confirm('Are you sure you want to remove this education record?')) {
                recordItem.remove();
            }
        }
    });
    
    // Remove existing education record (requires server request)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education-record') || 
            e.target.closest('.remove-education-record')) {
            const button = e.target.classList.contains('remove-education-record') ? 
                          e.target : e.target.closest('.remove-education-record');
            const recordId = button.getAttribute('data-id');
            const recordItem = button.closest('.education-record-item');
            
            if (confirm('Are you sure you want to delete this education record? This action cannot be undone.')) {
                // Send delete request
                fetch(`/plwd/education-records/${recordId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        recordItem.remove();
                        alert('Education record deleted successfully!');
                    } else {
                        alert('Error deleting education record. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting education record. Please try again.');
                });
            }
        }
    });
});
</script>
@endpush
