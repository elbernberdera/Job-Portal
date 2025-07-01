@extends('admin.base.base')

@section('page_title', 'Job Position Details')

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Job Position Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.job_positions.index') }}">Job Positions</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Job Position Details -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $jobPosition->job_title }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $jobPosition->status === 'open' ? 'success' : ($jobPosition->status === 'closed' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($jobPosition->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Position Code:</strong></td>
                                        <td>{{ $jobPosition->position_code }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Division:</strong></td>
                                        <td>{{ $jobPosition->division }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Region:</strong></td>
                                        <td>{{ $jobPosition->region }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monthly Salary:</strong></td>
                                        <td>₱{{ number_format($jobPosition->monthly_salary, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date Posted:</strong></td>
                                        <td>{{ $jobPosition->date_posted ? $jobPosition->date_posted->format('M d, Y') : 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Closing Date:</strong></td>
                                        <td>{{ $jobPosition->closing_date ? $jobPosition->closing_date->format('M d, Y') : 'Not set' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Requirements</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Min. Education:</strong></td>
                                        <td>{{ $jobPosition->min_education_level ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Min. Experience:</strong></td>
                                        <td>{{ $jobPosition->min_years_experience ? $jobPosition->min_years_experience . ' years' : 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Required Course:</strong></td>
                                        <td>{{ $jobPosition->required_course ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Required Eligibility:</strong></td>
                                        <td>{{ $jobPosition->required_eligibility ?: 'Not specified' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($jobPosition->education)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Education Requirements</h5>
                                <p>{{ $jobPosition->education }}</p>
                            </div>
                        </div>
                        @endif

                        @if($jobPosition->eligibility)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Eligibility Requirements</h5>
                                <p>{{ $jobPosition->eligibility }}</p>
                            </div>
                        </div>
                        @endif

                        @if($jobPosition->training && count($jobPosition->training) > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Training Requirements</h5>
                                <ul>
                                    @foreach($jobPosition->training as $training)
                                        <li>{{ $training }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if($jobPosition->experience && count($jobPosition->experience) > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Experience Requirements</h5>
                                <ul>
                                    @foreach($jobPosition->experience as $experience)
                                        <li>{{ $experience }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if($jobPosition->benefits && count($jobPosition->benefits) > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Benefits</h5>
                                <ul>
                                    @foreach($jobPosition->benefits as $benefit)
                                        <li>{{ $benefit['description'] }} - ₱{{ number_format($benefit['amount'], 2) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.job_positions.edit', $jobPosition->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Job Position
                            </a>
                            
                            @if($jobPosition->status !== 'archived')
                                <form action="{{ route('admin.job_positions.archive', $jobPosition->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary w-100" 
                                            onclick="return confirm('Are you sure you want to archive this job position?')">
                                        <i class="fas fa-archive"></i> Archive
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.job_positions.restore', $jobPosition->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" 
                                            onclick="return confirm('Are you sure you want to restore this job position?')">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.job_positions.destroy', $jobPosition->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" 
                                        onclick="return confirm('Are you sure you want to delete this job position? This action cannot be undone.')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Created By -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Created By</h3>
                    </div>
                    <div class="card-body">
                        @if($jobPosition->admin)
                            <p><strong>Admin:</strong> {{ $jobPosition->admin->first_name }} {{ $jobPosition->admin->last_name }}</p>
                            <p><strong>Email:</strong> {{ $jobPosition->admin->email }}</p>
                        @elseif($jobPosition->hr)
                            <p><strong>HR:</strong> {{ $jobPosition->hr->first_name }} {{ $jobPosition->hr->last_name }}</p>
                            <p><strong>Email:</strong> {{ $jobPosition->hr->email }}</p>
                        @else
                            <p class="text-muted">Unknown</p>
                        @endif
                        <p><strong>Created:</strong> {{ $jobPosition->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Updated:</strong> {{ $jobPosition->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <!-- Applications -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applications</h3>
                    </div>
                    <div class="card-body">
                        <h4>{{ $jobPosition->jobApplications->count() }}</h4>
                        <p class="text-muted">Total Applications</p>
                        
                        @if($jobPosition->jobApplications->count() > 0)
                            <div class="mt-3">
                                <h6>Recent Applications:</h6>
                                <ul class="list-unstyled">
                                    @foreach($jobPosition->jobApplications->take(5) as $application)
                                        <li class="mb-2">
                                            <strong>{{ $application->user->first_name }} {{ $application->user->last_name }}</strong><br>
                                            <small class="text-muted">{{ $application->created_at->format('M d, Y') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($jobPosition->jobApplications->count() > 5)
                                    <p class="text-muted">... and {{ $jobPosition->jobApplications->count() - 5 }} more</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 