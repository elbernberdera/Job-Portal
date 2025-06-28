@extends('hr.base.base')

@section('page_title')
    HR Dashboard
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Welcome, {{ Auth::user()->first_name ?? 'HR' }}!</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="small-box bg-primary shadow">
                    <div class="inner">
                        <h3 id="jobCount">{{ $jobCount ?? 0 }}</h3>
                        <p>My Job Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-briefcase"></i></div>
                    <a href="{{ route('job_vacancies') }}" class="small-box-footer">Manage Jobs <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="small-box bg-info shadow">
                    <div class="inner">
                        <h3 id="applicationCount">{{ $applicationCount ?? 0 }}</h3>
                        <p>Applications Received</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <a href="#" class="small-box-footer">View Applications <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="small-box bg-warning shadow">
                    <div class="inner">
                        <h3 id="shortlistedCount">{{ $shortlistedCount ?? 0 }}</h3>
                        <p>Shortlisted</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                    <a href="#" class="small-box-footer">View Shortlist <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3 id="hiredCount">{{ $hiredCount ?? 0 }}</h3>
                        <p>Hires Made</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-tie"></i></div>
                    <a href="#" class="small-box-footer">View Hires <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- Charts -->
        <div class="row mb-4">
            <div class="col-md-7 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Applications Over Time</h3>
                        <span class="badge badge-info" id="lastUpdate">Last updated: {{ now()->format('H:i:s') }}</span>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationsChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Application Status Breakdown</h3>
                        <span class="badge badge-info" id="lastUpdatePie">Last updated: {{ now()->format('H:i:s') }}</span>
                    </div>
                    <div class="card-body">
                        <canvas id="statusPieChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Latest Applications Table -->
        <div class="row mb-4">
            <div class="col-md-8 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Latest Applications</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Job Title</th>
                                        <th>Status</th>
                                        <th>Date Applied</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestApplications as $app)
                                        <tr>
                                            <td>{{ $app->user->first_name ?? '' }} {{ $app->user->last_name ?? '' }}</td>
                                            <td>{{ $app->jobVacancy->position_title ?? '' }}</td>
                                            <td>
                                                <span class="badge badge-{{
                                                    $app->status === 'pending' ? 'secondary' :
                                                    ($app->status === 'shortlisted' ? 'warning' :
                                                    ($app->status === 'hired' ? 'success' :
                                                    ($app->status === 'rejected' ? 'danger' : 'light'))
                                                )}} text-capitalize">
                                                    {{ $app->status }}
                                                </span>
                                            </td>
                                            <td>{{ $app->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-success" title="Shortlist"><i class="fas fa-user-check"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-danger" title="Reject"><i class="fas fa-user-times"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted">No recent applications.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Activity Feed -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Recent Activity</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentActivity as $log)
                                <li class="list-group-item small">
                                    <i class="fas fa-history text-info mr-2"></i>
                                    <span>{{ $log->activity ?? 'Activity' }}</span>
                                    <br>
                                    <span class="text-muted">{{ $log->created_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No recent activity.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-12 text-right">
                <a href="{{ route('job_vacancies') }}" class="btn btn-lg btn-primary mr-2"><i class="fas fa-plus"></i> Post New Job</a>
                <a href="#" class="btn btn-lg btn-info"><i class="fas fa-list"></i> View All Applications</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .small-box .icon {
        top: 10px;
        right: 10px;
        font-size: 48px;
        opacity: 0.2;
    }
    .small-box {
        border-radius: 0.75rem;
        transition: box-shadow 0.2s;
    }
    .small-box:hover {
        box-shadow: 0 4px 24px rgba(0,0,0,0.12);
    }
    .badge-warning, .badge-success, .badge-info, .badge-secondary, .badge-danger {
        font-size: 0.95em;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection

@section('extra_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let applicationsChart;
    let statusPieChart;

    // Initialize charts
    function initializeApplicationsChart(labels, data) {
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        applicationsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Applications',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
    function initializeStatusPieChart(labels, data) {
        const ctx = document.getElementById('statusPieChart').getContext('2d');
        statusPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(108, 117, 125, 0.7)', // Pending
                        'rgba(255, 193, 7, 0.7)',   // Shortlisted
                        'rgba(40, 167, 69, 0.7)',   // Hired
                        'rgba(220, 53, 69, 0.7)'    // Rejected
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
    // Update chart data
    function updateApplicationsChart(labels, data) {
        if (applicationsChart) {
            applicationsChart.data.labels = labels;
            applicationsChart.data.datasets[0].data = data;
            applicationsChart.update('none');
        }
    }
    function updateStatusPieChart(labels, data) {
        if (statusPieChart) {
            statusPieChart.data.labels = labels;
            statusPieChart.data.datasets[0].data = data;
            statusPieChart.update('none');
        }
    }
    // Update summary cards
    function updateCards(stats) {
        fadeUpdate('jobCount', stats.jobCount);
        fadeUpdate('applicationCount', stats.applicationCount);
        fadeUpdate('shortlistedCount', stats.shortlistedCount);
        fadeUpdate('hiredCount', stats.hiredCount);
    }
    // Fade effect for card updates
    function fadeUpdate(id, value) {
        const el = document.getElementById(id);
        if (el && el.textContent != value) {
            el.style.transition = 'opacity 0.3s';
            el.style.opacity = 0.3;
            setTimeout(() => {
                el.textContent = value;
                el.style.opacity = 1;
            }, 300);
        }
    }
    // Update last update timestamp
    function updateTimestamp() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        document.getElementById('lastUpdate').textContent = `Last updated: ${timeString}`;
        document.getElementById('lastUpdatePie').textContent = `Last updated: ${timeString}`;
    }
    // Fetch chart and card data (AJAX)
    function fetchDashboardData() {
        fetch("{{ url('/hr/dashboard/ajax-data') }}")
            .then(response => response.json())
            .then(data => {
                updateApplicationsChart(data.chartLabels, data.applicationsChartData);
                updateStatusPieChart(Object.keys(data.statusBreakdown), Object.values(data.statusBreakdown));
                updateCards(data.stats);
                updateTimestamp();
            })
            .catch(error => {
                console.error('Error fetching dashboard data:', error);
            });
    }
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeApplicationsChart(@json($chartLabels ?? []), @json($applicationsChartData ?? []));
        initializeStatusPieChart(@json(array_keys($statusBreakdown ?? [])), @json(array_values($statusBreakdown ?? [])));
        setInterval(fetchDashboardData, 10000); // Real-time update every 10s
    });
</script>
@endsection
