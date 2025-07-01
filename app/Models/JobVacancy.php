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
            return false;
        }

        $qualificationScore = 0;
        $totalCriteria = 0;
        $failedCriteria = [];

        // Check education level
        if ($this->min_education_level) {
            $totalCriteria++;
            $userEducationLevel = $this->getUserEducationLevel($profile);
            if ($this->isEducationLevelSufficient($userEducationLevel, $this->min_education_level)) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Education level: Required {$this->min_education_level}, Applicant has {$userEducationLevel}";
            }
        }

        // Check required course
        if ($this->required_course) {
            $totalCriteria++;
            $userCourses = $this->getUserCourses($profile);
            if (in_array(strtolower($this->required_course), array_map('strtolower', $userCourses))) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Required course: {$this->required_course}";
            }
        }

        // Check years of experience
        if ($this->min_years_experience) {
            $totalCriteria++;
            $userExperience = $this->getUserTotalExperience($profile);
            if ($userExperience >= $this->min_years_experience) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Experience: Required {$this->min_years_experience} years, Applicant has {$userExperience} years";
            }
        }

        // Check eligibility
        if ($this->required_eligibility) {
            $totalCriteria++;
            $userEligibilities = $this->getUserEligibilities($profile);
            if (in_array(strtolower($this->required_eligibility), array_map('strtolower', $userEligibilities))) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Required eligibility: {$this->required_eligibility}";
            }
        }

        // Check age requirements
        if ($this->age_min || $this->age_max) {
            $totalCriteria++;
            $userAge = $user->birth_date ? $user->birth_date->age : null;
            if ($userAge !== null) {
                $ageQualified = true;
                if ($this->age_min && $userAge < $this->age_min) {
                    $ageQualified = false;
                    $failedCriteria[] = "Age: Minimum {$this->age_min}, Applicant is {$userAge}";
                }
                if ($this->age_max && $userAge > $this->age_max) {
                    $ageQualified = false;
                    $failedCriteria[] = "Age: Maximum {$this->age_max}, Applicant is {$userAge}";
                }
                if ($ageQualified) {
                    $qualificationScore++;
                }
            } else {
                $failedCriteria[] = "Age: Unable to determine applicant age";
            }
        }

        // Check civil status requirement
        if ($this->civil_status_requirement && $profile->civil_status) {
            $totalCriteria++;
            if (strtolower($profile->civil_status) === strtolower($this->civil_status_requirement)) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Civil status: Required {$this->civil_status_requirement}, Applicant is {$profile->civil_status}";
            }
        }

        // Check citizenship requirement
        if ($this->citizenship_requirement && $profile->citizenship) {
            $totalCriteria++;
            if (strtolower($profile->citizenship) === strtolower($this->citizenship_requirement)) {
                $qualificationScore++;
            } else {
                $failedCriteria[] = "Citizenship: Required {$this->citizenship_requirement}, Applicant is {$profile->citizenship}";
            }
        }

        return [
            'qualified' => $totalCriteria > 0 && $qualificationScore === $totalCriteria,
            'score' => $qualificationScore,
            'total_criteria' => $totalCriteria,
            'percentage' => $totalCriteria > 0 ? round(($qualificationScore / $totalCriteria) * 100, 2) : 0,
            'failed_criteria' => $failedCriteria,
        ];
    }

    /**
     * Get user's highest education level
     */
    private function getUserEducationLevel($profile)
    {
        $levels = ['elementary', 'secondary', 'vocational', 'college', 'graduate'];
        $highestLevel = 'none';

        foreach ($levels as $level) {
            if ($profile->$level) {
                $educationData = json_decode($profile->$level, true);
                if (is_array($educationData) && !empty($educationData)) {
                    foreach ($educationData as $education) {
                        if (!empty($education['name_of_school']) && !empty($education['basic_education_degree_course'])) {
                            $highestLevel = $level;
                        }
                    }
                }
            }
        }

        return $highestLevel;
    }

    /**
     * Get user's courses/degrees
     */
    private function getUserCourses($profile)
    {
        $courses = [];
        $levels = ['elementary', 'secondary', 'vocational', 'college', 'graduate'];

        foreach ($levels as $level) {
            if ($profile->$level) {
                $educationData = json_decode($profile->$level, true);
                if (is_array($educationData)) {
                    foreach ($educationData as $education) {
                        if (!empty($education['basic_education_degree_course'])) {
                            $courses[] = $education['basic_education_degree_course'];
                        }
                    }
                }
            }
        }

        return array_unique($courses);
    }

    /**
     * Get user's total years of experience
     */
    private function getUserTotalExperience($profile)
    {
        if (!$profile->work_experience) {
            return 0;
        }

        $workExperience = json_decode($profile->work_experience, true);
        if (!is_array($workExperience)) {
            return 0;
        }

        $totalYears = 0;
        foreach ($workExperience as $experience) {
            if (!empty($experience['from']) && !empty($experience['to'])) {
                $from = \Carbon\Carbon::parse($experience['from']);
                $to = \Carbon\Carbon::parse($experience['to']);
                $totalYears += $from->diffInYears($to);
            }
        }

        return $totalYears;
    }

    /**
     * Get user's eligibilities
     */
    private function getUserEligibilities($profile)
    {
        if (!$profile->eligibility) {
            return [];
        }

        $eligibilities = json_decode($profile->eligibility, true);
        if (!is_array($eligibilities)) {
            return [];
        }

        $eligibilityList = [];
        foreach ($eligibilities as $eligibility) {
            if (!empty($eligibility['eligibility_name'])) {
                $eligibilityList[] = $eligibility['eligibility_name'];
            }
        }

        return $eligibilityList;
    }

    /**
     * Check if education level is sufficient
     */
    private function isEducationLevelSufficient($userLevel, $requiredLevel)
    {
        $levels = [
            'elementary' => 1,
            'secondary' => 2,
            'vocational' => 3,
            'college' => 4,
            'graduate' => 5
        ];

        $userLevelValue = $levels[$userLevel] ?? 0;
        $requiredLevelValue = $levels[strtolower($requiredLevel)] ?? 0;

        return $userLevelValue >= $requiredLevelValue;
    }
} 