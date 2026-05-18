<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }   
}