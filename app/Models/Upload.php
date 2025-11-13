<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'plwd_id',
        'file_path',
        'file_name',
        'type',
        'mime_type',
        'file_size',
    ];

    public function plwdProfile(): BelongsTo
    {
        return $this->belongsTo(PlwdProfile::class, 'plwd_id');
    }
}
