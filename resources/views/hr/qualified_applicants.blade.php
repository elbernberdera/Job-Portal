@extends('hr.base.base')
@section('main_content')
<div class="container">
    <!-- SweetAlert2 for session success/error -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            };
        </script>
    @endif

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Qualified Applicants</h3>
                    <div class="card-tools">
                        <span class="badge badge-success">{{ $qualifiedApplicants->count() }} Qualified Applicants</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Job Position</th>
                                    <th>Division</th>
                                    <th>Date Applied</th>
                                    <th>Qualification Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($qualifiedApplicants as $item)
                                    <tr @if(!$item['qualified']) style="background: #ffeaea;" @endif>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $item['application']->user->first_name }} {{ $item['application']->user->last_name }}</strong>
                                        </td>
                                        <td>{{ $item['application']->user->email }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $item['job']->job_title }}</span><br>
                                            <small class="text-muted">{{ $item['job']->position_code }}</small>
                                        </td>
                                        <td>{{ $item['job']->division }}</td>
                                        <td>{{ $item['application']->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                    <div class="progress-bar {{ $item['qualified'] ? 'bg-success' : 'bg-danger' }}" role="progressbar" 
                                                         style="width: {{ $item['percentage'] }}%"
                                                         aria-valuenow="{{ $item['percentage'] }}" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ $item['percentage'] }}%
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ $item['score'] }}/{{ $item['total_criteria'] }}</small>
                                            </div>
                                            @if(!$item['qualified'])
                                                <br>
                                                <span class="text-danger" title="Failed Criteria: {{ implode('; ', $item['failed_criteria']) }}">
                                                    <i class="fas fa-exclamation-circle"></i> Not qualified: {{ implode('; ', $item['failed_criteria']) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="" 
                                                   class="btn btn-info btn-sm" title="View PDS" target="_blank">
                                                    <i class="fas fa-id-card"></i> View PDS
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm" title="View Job Details" 
                                                        data-bs-toggle="modal" data-bs-target="#jobDetailsModal{{ $item['job']->id }}">
                                                    <i class="fas fa-eye"></i> Job Details
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <br>
                                            No applicants found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Details Modals -->
@foreach($qualifiedApplicants->pluck('job')->unique() as $job)
    <div class="modal fade" id="jobDetailsModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobDetailsModalLabel{{ $job->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailsModalLabel{{ $job->id }}">{{ $job->job_title }} - Job Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <ul class="list-unstyled">
                                <li><strong>Position Code:</strong> {{ $job->position_code }}</li>
                                <li><strong>Division:</strong> {{ $job->division }}</li>
                                <li><strong>Region:</strong> {{ $job->region }}</li>
                                <li><strong>Monthly Salary:</strong> ₱{{ number_format($job->monthly_salary, 2) }}</li>
                                <li><strong>Status:</strong> 
                                    <span class="badge {{ $job->getStatusBadgeClass() }}">{{ $job->getStatusDisplayText() }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Qualification Criteria</h6>
                            <ul class="list-unstyled">
                                @if($job->min_education_level)
                                    <li><strong>Min Education:</strong> {{ ucfirst($job->min_education_level) }}</li>
                                @endif
                                @if($job->required_course)
                                    <li><strong>Required Course:</strong> {{ $job->required_course }}</li>
                                @endif
                                @if($job->min_years_experience)
                                    <li><strong>Min Experience:</strong> {{ $job->min_years_experience }} years</li>
                                @endif
                                @if($job->required_eligibility)
                                    <li><strong>Required Eligibility:</strong> {{ $job->required_eligibility }}</li>
                                @endif
                                @if($job->age_min || $job->age_max)
                                    <li><strong>Age Range:</strong> 
                                        @if($job->age_min && $job->age_max)
                                            {{ $job->age_min }} - {{ $job->age_max }} years
                                        @elseif($job->age_min)
                                            {{ $job->age_min }}+ years
                                        @elseif($job->age_max)
                                            Up to {{ $job->age_max }} years
                                        @endif
                                    </li>
                                @endif
                                @if($job->civil_status_requirement)
                                    <li><strong>Civil Status:</strong> {{ $job->civil_status_requirement }}</li>
                                @endif
                                @if($job->citizenship_requirement)
                                    <li><strong>Citizenship:</strong> {{ $job->citizenship_requirement }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection 