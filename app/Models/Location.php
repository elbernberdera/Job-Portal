<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region',
        'province',
        'city',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the job vacancies for this location
     */
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'location_id');
    }

    /**
     * Scope to get only active locations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full address
     */
    public function getFullAddressAttribute()
    {
        return "{$this->city}, {$this->province}, {$this->region}";
    }
} 