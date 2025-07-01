@extends('admin.base.base')

@section('page_title')
    Admin Dashboard
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Welcome, {{ Auth::user()->first_name ?? 'Admin' }}!</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.job_positions.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> New Job Position
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

<!-- Notifications Section -->
@if($pendingReviews > 0 || $thisMonthApplications > 0)
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-info"></i> Quick Actions Needed!</h5>
                    @if($pendingReviews > 0)
                        <p><strong>{{ $pendingReviews }}</strong> job applications need review.</p>
                    @endif
                    @if($thisMonthApplications > 0)
                        <p><strong>{{ $thisMonthApplications }}</strong> new applications this month.</p>
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('admin.job_positions.index') }}" class="btn btn-sm btn-primary">Review Applications</a>
                        <a href="{{ route('admin.accounts') }}" class="btn btn-sm btn-outline-secondary">Manage Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="userCount">{{ $userCount ?? 0 }}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.accounts') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Job Posts -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="jobCount">{{ $jobCount ?? 0 }}</h3>
                        <p>Job Posts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="{{ route('admin.job_positions.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Applications -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="applicationCount">{{ $applicationCount ?? 0 }}</h3>
                        <p>Applications</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Logs -->
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="logCount">{{ $logCount ?? 0 }}</h3>
                        <p>Logs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <a href="{{ route('admin.logs') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Quick Statistics Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-user-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active Users</span>
                        <span class="info-box-number" id="activeUsers">{{ $activeUsers ?? 0 }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $activeUsersPercentage ?? 0 }}%"></div>
                        </div>
                        <span class="progress-description">{{ $activeUsersPercentage ?? 0 }}% of total users</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Qualified Applicants</span>
                        <span class="info-box-number" id="qualifiedApplicants">{{ $qualifiedApplicants ?? 0 }}</span>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $qualifiedPercentage ?? 0 }}%"></div>
                        </div>
                        <span class="progress-description">{{ $qualifiedPercentage ?? 0 }}% of applications</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pending Reviews</span>
                        <span class="info-box-number" id="pendingReviews">{{ $pendingReviews ?? 0 }}</span>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: {{ $pendingPercentage ?? 0 }}%"></div>
                        </div>
                        <span class="progress-description">{{ $pendingPercentage ?? 0 }}% need attention</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">This Month</span>
                        <span class="info-box-number" id="thisMonthApplications">{{ $thisMonthApplications ?? 0 }}</span>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: {{ $monthlyGrowth ?? 0 }}%"></div>
                        </div>
                        <span class="progress-description">{{ $monthlyGrowth ?? 0 }}% vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart & Recent Activity -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applicants by Gender & Passer Status</h3>
                        <div class="card-tools">
                            <span class="badge badge-info" id="lastUpdate">Last updated: {{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Registered Users Over Time</h3>
                        <div class="card-tools">
                            <span class="badge badge-info" id="lastUpdateUsers">Last updated: {{ now()->format('H:i:s') }}</span>
                            <span class="badge badge-warning d-none" id="updatingIndicatorUsers">Updating...</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="usersChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications & System Health -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Job Applications</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.job_positions.index') }}" class="btn btn-sm btn-outline-primary">View All Applications</a>
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
                                <tbody id="recentApplicationsTable">
                                    @forelse($recentApplications ?? [] as $application)
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">System Health</h3>
                    </div>
                    <div class="card-body">
                        <div class="system-health-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Database</span>
                                <span class="badge badge-success">Healthy</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="system-health-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Storage</span>
                                <span class="badge badge-info">{{ $storageUsage ?? '75%' }}</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-info" style="width: {{ $storageUsage ?? 75 }}%"></div>
                            </div>
                        </div>
                        <div class="system-health-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Active Sessions</span>
                                <span class="badge badge-primary">{{ $activeSessions ?? 0 }}</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-primary" style="width: {{ $sessionPercentage ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div class="system-health-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Uptime</span>
                                <span class="badge badge-success">{{ $uptime ?? '99.9%' }}</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: 99.9%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activity</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="recentActivities">
                            @forelse($recentActivities ?? [] as $activity)
                                <li class="list-group-item">{{ $activity }}</li>
                            @empty
                                <li class="list-group-item text-muted">No recent activity.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .badge-warning {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .card-tools {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-tools .badge {
        font-size: 0.75rem;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    .system-health-item .progress {
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .info-box .progress {
        height: 3px;
        margin: 5px 0;
    }

    .info-box .progress-description {
        font-size: 0.75rem;
        color: #6c757d;
    }

    #donutChart {
        max-width: 350px;
        max-height: 350px;
        width: 100% !important;
        height: auto !important;
        margin: 0 auto;
        display: block;
    }
</style>
@endsection

@section('extra_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let donutChart;
    let usersChart;

    function initializeDonutChart(labels, data) {
        const ctx = document.getElementById('donutChart').getContext('2d');
        donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#2563eb', // Male Passer
                        '#60a5fa', // Male Not Passer
                        '#f472b6', // Female Passer
                        '#fbbf24'  // Female Not Passer
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { enabled: true }
                }
            }
        });
    }

    function initializeUsersChart(labels, data) {
        const ctx = document.getElementById('usersChart').getContext('2d');
        usersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Users',
                    data: data,
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Donut chart data from backend
        const donutLabels = @json(array_keys($donutChartData));
        const donutData = @json(array_values($donutChartData));
        initializeDonutChart(donutLabels, donutData);
        // Users chart (keep as is)
        initializeUsersChart(@json($chartLabels ?? []), @json($usersChartData ?? []));
    });
</script>
@endsection
