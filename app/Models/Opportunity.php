<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'organization',
        'type',
        'deadline',
        'contact_email',
        'contact_phone',
        'website_url',
        'status',
        'views',
    ];

    protected $casts = [
        'deadline' => 'date',
        'views' => 'integer',
    ];

    /**
     * Scope to get only active opportunities
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get opportunities that haven't expired
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('deadline')
              ->orWhere('deadline', '>=', now());
        });
    }

    /**
     * Check if opportunity is expired
     */
    public function isExpired()
    {
        if (!$this->deadline) {
            return false;
        }
        return $this->deadline < now();
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

