@extends('admin.base.base')

@section('page_title')
    Admin Dashboard - Overview
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard Overview</h1>
                <p class="text-muted">Welcome back, {{ Auth::user()->first_name ?? 'Admin' }}!</p>
            </div>
            <div class="col-sm-6">
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.job_positions.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> New Job
                        </a>
                        <a href="{{ route('admin.accounts') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-user-plus"></i> Add User
                        </a>
                        <a href="{{ route('admin.logs') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-eye"></i> View Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Key Statistics Row -->
        <div class="row">
            <!-- Total Job Listings -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ number_format($totalJobListings) }}</h3>
                        <p>Total Job Listings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="{{ route('admin.job_positions.index') }}" class="small-box-footer">
                        View All Jobs <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- HR Users -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($hrUsers) }}</h3>
                        <p>HR Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('admin.accounts') }}" class="small-box-footer">
                        Manage Users <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Applicant Users -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($applicantUsers) }}</h3>
                        <p>Registered Applicants</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.accounts') }}" class="small-box-footer">
                        View Applicants <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Applications -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($totalApplications) }}</h3>
                        <p>Total Applications</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <a href="{{ route('admin.job_positions.index') }}" class="small-box-footer">
                        Review Applications <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Application Status Overview -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Application Status Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending Review</span>
                                        <span class="info-box-number">{{ number_format($pendingApplications) }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $totalApplications > 0 ? ($pendingApplications / $totalApplications) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            {{ $totalApplications > 0 ? round(($pendingApplications / $totalApplications) * 100, 1) : 0 }}% of total applications
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Approved</span>
                                        <span class="info-box-number">{{ number_format($approvedApplications) }}</span>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ $totalApplications > 0 ? ($approvedApplications / $totalApplications) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            {{ $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 1) : 0 }}% of total applications
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Rejected</span>
                                        <span class="info-box-number">{{ number_format($rejectedApplications) }}</span>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: {{ $totalApplications > 0 ? ($rejectedApplications / $totalApplications) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            {{ $totalApplications > 0 ? round(($rejectedApplications / $totalApplications) * 100, 1) : 0 }}% of total applications
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Job Post Trends -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Job Post Trends (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="jobTrendsChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- User Activity -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Registration Activity (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="userActivityChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution Charts Row -->
        <div class="row">
            <!-- Application Status Distribution -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Application Status Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationStatusChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- User Role Distribution -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Role Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="userRoleChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications & Activity Logs -->
        <div class="row">
            <!-- Recent Applications -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Job Applications</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.job_positions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $application)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center mr-2">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $application->user->first_name }} {{ $application->user->last_name }}</div>
                                                    <small class="text-muted">{{ $application->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $application->jobVacancy->position_title }}</td>
                                        <td>
                                            @if(in_array($application->status, ['shortlisted', 'interviewed', 'offered', 'hired']))
                                                <span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                            @elseif(in_array($application->status, ['applied', 'under_review']))
                                                <span class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-info">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No recent applications</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Logs -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activity Logs</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="activity-feed">
                            @forelse($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $activity['type'] === 'login' ? 'bg-success' : 'bg-warning' }}">
                                        <i class="fas {{ $activity['type'] === 'login' ? 'fa-sign-in-alt' : 'fa-sign-out-alt' }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>{{ $activity['user'] }}</strong> {{ $activity['action'] }}
                                        </div>
                                        <div class="activity-time">
                                            {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3">No recent activity</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .info-box {
        min-height: 80px;
    }
    
    .info-box-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.875rem;
    }
    
    .info-box-content {
        padding: 5px 10px;
    }
    
    .info-box-number {
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    .info-box-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .progress {
        height: 3px;
        margin: 5px 0;
    }
    
    .progress-description {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .activity-feed {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 15px;
        border-bottom: 1px solid #f4f6f9;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        margin-right: 12px;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-text {
        font-size: 0.875rem;
        margin-bottom: 2px;
    }
    
    .activity-time {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .card-tools {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection

@section('extra_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Job Trends Chart
        const jobTrendsCtx = document.getElementById('jobTrendsChart').getContext('2d');
        new Chart(jobTrendsCtx, {
            type: 'line',
            data: {
                labels: @json($jobTrendLabels),
                datasets: [{
                    label: 'Job Posts',
                    data: @json($jobTrendData),
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // User Activity Chart
        const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
        new Chart(userActivityCtx, {
            type: 'line',
            data: {
                labels: @json($userActivityLabels),
                datasets: [{
                    label: 'New Users',
                    data: @json($userActivityData),
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Application Status Chart
        const applicationStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
        new Chart(applicationStatusCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($applicationStatusData)),
                datasets: [{
                    data: @json(array_values($applicationStatusData)),
                    backgroundColor: [
                        '#fbbf24', // Pending - Warning
                        '#22c55e', // Approved - Success
                        '#ef4444'  // Rejected - Danger
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // User Role Chart
        const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
        new Chart(userRoleCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($userRoleData)),
                datasets: [{
                    data: @json(array_values($userRoleData)),
                    backgroundColor: [
                        '#22c55e', // HR Users - Success
                        '#3b82f6'  // Applicants - Info
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endsection
