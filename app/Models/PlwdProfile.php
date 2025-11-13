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
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'verified' => 'boolean',
        'skills' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
