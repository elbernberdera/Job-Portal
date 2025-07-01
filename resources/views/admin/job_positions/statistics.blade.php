@extends('admin.base.base')

@section('page_title', 'Job Position Statistics')

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Statistics: {{ $jobPosition->job_title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.job_positions.index') }}">Job Positions</a></li>
                    <li class="breadcrumb-item active">Statistics</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Job Position Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Job Position Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Job Title:</strong></td>
                                <td>{{ $jobPosition->job_title }}</td>
                            </tr>
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
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $jobPosition->status === 'open' ? 'success' : ($jobPosition->status === 'closed' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($jobPosition->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total Applications:</strong></td>
                                <td><span class="badge badge-info">{{ $qualificationData['total'] }}</span></td>
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
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Gender Distribution -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users text-primary"></i> Gender Distribution
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="bg-primary text-white rounded p-3 mb-3">
                                    <h2 class="mb-0">{{ $genderData['male'] }}</h2>
                                    <small>Male Applicants</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-info text-white rounded p-3 mb-3">
                                    <h2 class="mb-0">{{ $genderData['female'] }}</h2>
                                    <small>Female Applicants</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($genderData['total'] > 0)
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-primary" style="width: {{ ($genderData['male'] / $genderData['total']) * 100 }}%">
                                    {{ round(($genderData['male'] / $genderData['total']) * 100, 1) }}%
                                </div>
                                <div class="progress-bar bg-info" style="width: {{ ($genderData['female'] / $genderData['total']) * 100 }}%">
                                    {{ round(($genderData['female'] / $genderData['total']) * 100, 1) }}%
                                </div>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <small class="text-muted">Total: {{ $genderData['total'] }} applicants</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Qualification Status -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-check-circle text-success"></i> Qualification Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="bg-success text-white rounded p-3 mb-3">
                                    <h2 class="mb-0">{{ $qualificationData['qualified'] }}</h2>
                                    <small>Passer</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-warning text-white rounded p-3 mb-3">
                                    <h2 class="mb-0">{{ $qualificationData['not_qualified'] }}</h2>
                                    <small>Not Passer</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($qualificationData['total'] > 0)
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" style="width: {{ ($qualificationData['qualified'] / $qualificationData['total']) * 100 }}%">
                                    {{ round(($qualificationData['qualified'] / $qualificationData['total']) * 100, 1) }}%
                                </div>
                                <div class="progress-bar bg-warning" style="width: {{ ($qualificationData['not_qualified'] / $qualificationData['total']) * 100 }}%">
                                    {{ round(($qualificationData['not_qualified'] / $qualificationData['total']) * 100, 1) }}%
                                </div>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <small class="text-muted">Total: {{ $qualificationData['total'] }} applicants</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Lists -->
        <div class="row">
            <!-- Qualified Applicants -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-check text-success"></i> Qualified Applicants ({{ count($qualificationData['qualified_details']) }})
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(count($qualificationData['qualified_details']) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Score</th>
                                            <th>Applied</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($qualificationData['qualified_details'] as $detail)
                                            <tr>
                                                <td>
                                                    <strong>{{ $detail['user']->first_name }} {{ $detail['user']->last_name }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $detail['user']->sex === 'male' ? 'primary' : 'info' }}">
                                                        {{ ucfirst($detail['user']->sex) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">
                                                        {{ $detail['result']['percentage'] ?? 0 }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $detail['application']->created_at->format('M d, Y') }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No qualified applicants yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Not Qualified Applicants -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-times text-warning"></i> Not Qualified Applicants ({{ count($qualificationData['not_qualified_details']) }})
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(count($qualificationData['not_qualified_details']) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Score</th>
                                            <th>Applied</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($qualificationData['not_qualified_details'] as $detail)
                                            <tr>
                                                <td>
                                                    <strong>{{ $detail['user']->first_name }} {{ $detail['user']->last_name }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $detail['user']->sex === 'male' ? 'primary' : 'info' }}">
                                                        {{ ucfirst($detail['user']->sex) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($detail['result'])
                                                        <span class="badge badge-warning">
                                                            {{ $detail['result']['percentage'] ?? 0 }}%
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $detail['application']->created_at->format('M d, Y') }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No unqualified applicants</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('admin.job_positions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Job Positions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .progress {
        border-radius: 10px;
    }
    
    .card-body .bg-primary,
    .card-body .bg-info,
    .card-body .bg-success,
    .card-body .bg-warning {
        transition: transform 0.2s;
        border-radius: 8px;
    }
    
    .card-body .bg-primary:hover,
    .card-body .bg-info:hover,
    .card-body .bg-success:hover,
    .card-body .bg-warning:hover {
        transform: scale(1.02);
    }
    
    .table-sm td, .table-sm th {
        padding: 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection 