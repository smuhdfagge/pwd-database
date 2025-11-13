<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'plwd_profile_id',
        'education_level_id',
        'institution',
        'from_year',
        'to_year',
        'certificate_obtained',
        'document_path',
    ];

    protected $casts = [
        'from_year' => 'integer',
        'to_year' => 'integer',
    ];

    /**
     * Get the PLWD profile that owns the education record.
     */
    public function plwdProfile(): BelongsTo
    {
        return $this->belongsTo(PlwdProfile::class);
    }

    /**
     * Get the education level.
     */
    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
