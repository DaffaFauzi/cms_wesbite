<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'company_id',
        'file_path',
        'file_type',
        'original_name',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the public URL for this media file.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }
}