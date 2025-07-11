<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobApplication;
use Carbon\Carbon;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'position_code',
        'division',
        'region',
        'salary_grade',
        'monthly_salary',
        'education',
        'training',
        'experience',
        'eligibility',
        'benefits',
        'status',
        'date_posted',
        'closing_date',
        'hr_id',
        'admin_id',
        // Qualification criteria
        'min_education_level',
        'required_course',
        'min_years_experience',
        'required_eligibility',
        'required_skills',
        'age_min',
        'age_max',
        'civil_status_requirement',
        'citizenship_requirement',
    ];

    protected $casts = [
        'benefits' => 'array',
        'training' => 'array',
        'experience' => 'array',
        'monthly_salary' => 'decimal:2',
        'date_posted' => 'date',
        'closing_date' => 'date',
        'required_skills' => 'array',
    ];

    // Status constants
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';
    const STATUS_ARCHIVED = 'archived';

    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // Scope for active jobs (open and closed)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_ARCHIVED]);
    }

    // Scope for archived jobs
    public function scopeArchived($query)
    {
        return $query->where('status', self::STATUS_ARCHIVED);
    }

    // Scope for open jobs only
    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    // Check if job is expired (past closing date)
    public function isExpired()
    {
        return $this->closing_date && Carbon::today()->gt($this->closing_date);
    }

    // Check if job should be archived
    public function shouldBeArchived()
    {
        return $this->status === self::STATUS_OPEN && $this->isExpired();
    }

    // Archive the job
    public function archive()
    {
        $this->status = self::STATUS_ARCHIVED;
        return $this->save();
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_OPEN => 'badge-success',
            self::STATUS_CLOSED => 'badge-warning',
            self::STATUS_ARCHIVED => 'badge-secondary',
            default => 'badge-light',
        };
    }

    // Get status display text
    public function getStatusDisplayText()
    {
        return ucfirst($this->status);
    }

    /**
     * Check if an applicant is qualified based on PDS data
     */
    public function checkQualification($user)
    {
        $profile = $user->profile;
        if (!$profile) {
            return ['qualified' => false];
        }

        // Pass all job requirements to profile scoring
        $scoreData = $profile->calculateQualificationScore(
            $this->required_course,
            $this->min_years_experience,
            $this->required_eligibility,
            $this->required_skills
        );
        $score = $scoreData['score'];
        $breakdown = $scoreData['breakdown'];
        $totalCriteria = 100;
        $percentage = round(($score / $totalCriteria) * 100);

        $minPassingScore = 70; // Minimum score to qualify

        $failedCriteria = [];

        // Education level check
        if (empty($profile->graduate) && empty($profile->college)) {
            $failedCriteria[] = 'Education Level';
        }

        // Course/Degree alignment check
        $collegeArr = json_decode($profile->college, true);
        $applicantCourse = '';
        if (is_array($collegeArr) && count($collegeArr) > 0) {
            $applicantCourse = strtolower(trim(
                $collegeArr[0]['degree'] ?? $collegeArr[0]['basic_education_degree_course'] ?? ''
            ));
        } else {
            $applicantCourse = strtolower(trim($profile->college ?? ''));
        }
        $requiredCourse = strtolower(trim($this->required_course ?? ''));

        if ($requiredCourse !== '' && $applicantCourse !== $requiredCourse &&
            strpos($applicantCourse, $requiredCourse) === false &&
            strpos($requiredCourse, $applicantCourse) === false) {
            $failedCriteria[] = 'Course/Degree Alignment';
        }

        // Work experience check
        if (empty($profile->work_experience)) {
            $failedCriteria[] = 'Work Experience';
        }

        // Eligibility check
        $eligibility = json_decode($profile->eligibility, true);
        if (empty($eligibility) || count($eligibility) === 0) {
            $failedCriteria[] = 'Eligibility';
        }

        $qualified = $score >= $minPassingScore;

        return [
            'qualified' => $qualified,
            'score' => $score,
            'percentage' => $percentage,
            'total_criteria' => $totalCriteria,
            'failed_criteria' => $qualified ? [] : $failedCriteria,
            'breakdown' => $breakdown,
        ];
    }
} 