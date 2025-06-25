<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobApplication;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'position_code',
        'division',
        'region',
        'monthly_salary',
        'education',
        'training',
        'experience',
        'eligibility',
        'benefits',
        'status',
        'date_posted',
    ];

    protected $casts = [
        'benefits' => 'array',
        'training' => 'array',
        'experience' => 'array',
    ];

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
} 