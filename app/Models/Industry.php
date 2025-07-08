<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the job vacancies for this industry
     */
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'industry_id');
    }

    /**
     * Scope to get only active industries
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 