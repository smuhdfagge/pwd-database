<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlwdProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'state',
        'lga',
        'disability_type_id',
        'education_level_id',
        'skills',
        'bio',
        'verified',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'verified' => 'boolean',
        'skills' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disabilityType(): BelongsTo
    {
        return $this->belongsTo(DisabilityType::class);
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class, 'plwd_id');
    }

    public function educationRecords(): HasMany
    {
        return $this->hasMany(EducationRecord::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Calculate profile completion percentage based on required fields.
     * Required fields: gender, date_of_birth, phone, address, state, lga, disability_type_id, education_level_id
     * Optional fields that contribute to completion: skills, bio, photo
     * 
     * @return float
     */
    public function getProfileCompletionAttribute(): float
    {
        // Define required fields (8 fields)
        $requiredFields = [
            'gender',
            'date_of_birth',
            'phone',
            'address',
            'state',
            'lga',
            'disability_type_id',
            'education_level_id',
        ];

        // Define optional fields that enhance profile (3 fields)
        $optionalFields = [
            'skills',
            'bio',
            'photo',
        ];

        $totalFields = count($requiredFields) + count($optionalFields);
        $filledFields = 0;

        // Check required fields
        foreach ($requiredFields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        // Check optional fields
        foreach ($optionalFields as $field) {
            if ($field === 'skills') {
                // Check if skills array has at least one skill
                if (is_array($this->skills) && count($this->skills) > 0) {
                    $filledFields++;
                }
            } else {
                if (!empty($this->$field)) {
                    $filledFields++;
                }
            }
        }

        // Calculate percentage
        return round(($filledFields / $totalFields) * 100, 1);
    }

    /**
     * Get the count of completed required fields.
     * 
     * @return int
     */
    public function getCompletedRequiredFieldsAttribute(): int
    {
        $requiredFields = [
            'gender',
            'date_of_birth',
            'phone',
            'address',
            'state',
            'lga',
            'disability_type_id',
            'education_level_id',
        ];

        $completed = 0;
        foreach ($requiredFields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        return $completed;
    }

    /**
     * Get the total number of required fields.
     * 
     * @return int
     */
    public function getTotalRequiredFieldsAttribute(): int
    {
        return 8; // Total required fields
    }

    /**
     * Check if all required fields are completed.
     * 
     * @return bool
     */
    public function getIsCompleteAttribute(): bool
    {
        return $this->completed_required_fields === $this->total_required_fields;
    }

    /**
     * Get an array of missing required fields.
     * 
     * @return array
     */
    public function getMissingRequiredFieldsAttribute(): array
    {
        $requiredFields = [
            'gender' => 'Gender',
            'date_of_birth' => 'Date of Birth',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'state' => 'State',
            'lga' => 'Local Government Area',
            'disability_type_id' => 'Disability Type',
            'education_level_id' => 'Education Level',
        ];

        $missing = [];
        foreach ($requiredFields as $field => $label) {
            if (empty($this->$field)) {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    /**
     * Get an array of missing optional fields that enhance profile.
     * 
     * @return array
     */
    public function getMissingOptionalFieldsAttribute(): array
    {
        $optionalFields = [
            'skills' => 'Skills',
            'bio' => 'Personal Bio',
            'photo' => 'Profile Photo',
        ];

        $missing = [];
        foreach ($optionalFields as $field => $label) {
            if ($field === 'skills') {
                if (!is_array($this->skills) || count($this->skills) === 0) {
                    $missing[] = $label;
                }
            } else {
                if (empty($this->$field)) {
                    $missing[] = $label;
                }
            }
        }

        return $missing;
    }
}
