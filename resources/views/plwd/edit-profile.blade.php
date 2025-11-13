@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h4>
    </div>
    <div class="card-body">
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
                                <label for="education_level_id" class="form-label">Education Level *</label>
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

                            <!-- Bio -->
                            <div class="col-md-12 mb-3">
                                <label for="bio" class="form-label">Personal Bio (Optional)</label>
                                <textarea name="bio" id="bio" class="form-control" rows="4" maxlength="1000" placeholder="Tell us about yourself...">{{ old('bio', $profile->bio) }}</textarea>
                                <small class="text-muted">Maximum 1000 characters</small>
                            </div>

                            <!-- Geolocation (Optional) -->
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude (Optional)</label>
                                <input type="number" step="any" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $profile->latitude) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude (Optional)</label>
                                <input type="number" step="any" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $profile->longitude) }}">
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
