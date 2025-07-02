@extends('user.base.base')



@section('main_content')
<div class="container mt-4">
    <div class="row">
        <!-- Job Details Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-briefcase me-2"></i>
                        {{ $job->job_title }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Position Details</h6>
                            <ul class="list-unstyled">
                                <li><strong>Position Code:</strong> {{ $job->position_code }}</li>
                                <li><strong>Division:</strong> {{ $job->division }}</li>
                                <li><strong>Region:</strong> {{ $job->region }}</li>
                                <li><strong>Monthly Salary:</strong> ₱{{ number_format($job->monthly_salary, 2) }}</li>
                                <li><strong>Status:</strong> 
                                    <span class="badge bg-success">{{ ucfirst($job->status) }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Important Dates</h6>
                            <ul class="list-unstyled">
                                <li><strong>Date Posted:</strong> {{ $job->date_posted ? \Carbon\Carbon::parse($job->date_posted)->format('F d, Y') : 'Not specified' }}</li>
                                <li><strong>Closing Date:</strong> 
                                    @if($job->closing_date)
                                        {{ \Carbon\Carbon::parse($job->closing_date)->format('F d, Y') }}
                                        @if(\Carbon\Carbon::parse($job->closing_date)->isPast())
                                            <span class="badge bg-danger">Closed</span>
                                        @else
                                            <span class="badge bg-warning">Open</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No closing date</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted mb-2">Requirements</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Education</h6>
                            <p>{{ $job->education ?: 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Eligibility</h6>
                            <p>{{ $job->eligibility ?: 'Not specified' }}</p>
                        </div>
                    </div>

                    @if($job->training && is_array($job->training) && count($job->training))
                    <div class="mb-3">
                        <h6>Training</h6>
                        <ul>
                            @foreach($job->training as $training)
                                <li>{{ $training }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($job->experience && is_array($job->experience) && count($job->experience))
                    <div class="mb-3">
                        <h6>Experience</h6>
                        <ul>
                            @foreach($job->experience as $experience)
                                <li>{{ $experience }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($job->benefits && is_array($job->benefits) && count($job->benefits))
                    <div class="mb-3">
                        <h6>Benefits</h6>
                        <ul>
                            @foreach($job->benefits as $benefit)
                                <li>
                                    @if(isset($benefit['amount']) && isset($benefit['description']))
                                        ₱{{ number_format($benefit['amount'], 2) }} - {{ $benefit['description'] }}
                                    @elseif(is_string($benefit))
                                        {{ $benefit }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($job->min_education_level || $job->required_course || $job->min_years_experience || $job->required_eligibility)
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Qualification Criteria</h6>
                        <ul class="mb-0">
                            @if($job->min_education_level)
                                <li><strong>Minimum Education:</strong> {{ $job->min_education_level }}</li>
                            @endif
                            @if($job->required_course)
                                <li><strong>Required Course:</strong> {{ $job->required_course }}</li>
                            @endif
                            @if($job->min_years_experience)
                                <li><strong>Minimum Experience:</strong> {{ $job->min_years_experience }} years</li>
                            @endif
                            @if($job->required_eligibility)
                                <li><strong>Required Eligibility:</strong> {{ $job->required_eligibility }}</li>
                            @endif
                            @if($job->age_min || $job->age_max)
                                <li><strong>Age Requirement:</strong> 
                                    @if($job->age_min && $job->age_max)
                                        {{ $job->age_min }} - {{ $job->age_max }} years old
                                    @elseif($job->age_min)
                                        Minimum {{ $job->age_min }} years old
                                    @elseif($job->age_max)
                                        Maximum {{ $job->age_max }} years old
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Application Form Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        Submit Application
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> Please ensure your profile is complete before applying.
                        </div>
                    </div>

                    <form action="{{ route('user.apply', $job->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Job Position</label>
                            <input type="text" class="form-control" value="{{ $job->job_title }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position Code</label>
                            <input type="text" class="form-control" value="{{ $job->position_code }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Division</label>
                            <input type="text" class="form-control" value="{{ $job->division }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Monthly Salary</label>
                            <input type="text" class="form-control" value="₱{{ number_format($job->monthly_salary, 2) }}" readonly>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Application
                            </button>
                            <a href="{{ route('user.job.vacancies') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Job Listings
                            </a>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            By submitting this application, you confirm that all information in your profile is accurate and complete.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_css')
<style>
.card {
    border-radius: 12px;
    border: 1px solid #e3e6f0;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: none;
}

.alert {
    border-radius: 8px;
}

.btn {
    border-radius: 8px;
}

.form-control {
    border-radius: 6px;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection 