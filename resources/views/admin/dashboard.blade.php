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
        </div>
    </div>
</div>

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
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
        <!-- Chart & Recent Activity -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applications Over Time</h3>
                        <div class="card-tools">
                            <span class="badge badge-info" id="lastUpdate">Last updated: {{ now()->format('H:i:s') }}</span>
                            <span class="badge badge-warning d-none" id="updatingIndicator">Updating...</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationsChart" height="120"></canvas>
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
</style>
@endsection

@section('extra_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let applicationsChart;
    let usersChart;
    
    // Initialize applications chart
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
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Initialize users chart
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

    // Update applications chart data
    function updateApplicationsChart(labels, data) {
        if (applicationsChart) {
            applicationsChart.data.labels = labels;
            applicationsChart.data.datasets[0].data = data;
            applicationsChart.update('none');
        }
    }

    // Update users chart data
    function updateUsersChart(labels, data) {
        if (usersChart) {
            usersChart.data.labels = labels;
            usersChart.data.datasets[0].data = data;
            usersChart.update('none');
        }
    }

    // Update statistics
    function updateStats(stats) {
        fadeUpdate('userCount', stats.userCount);
        fadeUpdate('jobCount', stats.jobCount);
        fadeUpdate('applicationCount', stats.applicationCount);
        fadeUpdate('logCount', stats.logCount);
    }

    // Fade effect for card updates
    function fadeUpdate(id, value) {
        const el = document.getElementById(id);
        if (el.textContent != value) {
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
        document.getElementById('lastUpdateUsers').textContent = `Last updated: ${timeString}`;
    }

    // Show/hide updating indicator
    function showUpdatingIndicator() {
        document.getElementById('updatingIndicator').classList.remove('d-none');
        document.getElementById('updatingIndicatorUsers').classList.remove('d-none');
    }

    function hideUpdatingIndicator() {
        document.getElementById('updatingIndicator').classList.add('d-none');
        document.getElementById('updatingIndicatorUsers').classList.add('d-none');
    }

    // Fetch chart data
    function fetchChartData() {
        showUpdatingIndicator();
        fetch("{{ route('admin.dashboard.chart-data') }}")
            .then(response => response.json())
            .then(data => {
                updateApplicationsChart(data.labels, data.applications);
                updateUsersChart(data.labels, data.users);
                updateTimestamp();
                hideUpdatingIndicator();
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                hideUpdatingIndicator();
            });
    }

    // Fetch statistics
    function fetchStats() {
        fetch("{{ route('admin.dashboard.stats') }}")
            .then(response => response.json())
            .then(data => {
                updateStats(data);
            })
            .catch(error => {
                console.error('Error fetching stats:', error);
            });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts with initial data
        initializeApplicationsChart(@json($chartLabels ?? []), @json($chartData ?? []));
        initializeUsersChart(@json($chartLabels ?? []), @json($usersChartData ?? []));
        
        // Set up real-time updates
        setInterval(function() {
            fetchChartData();
            fetchStats();
        }, 10000); // Update every 10 seconds
    });
</script>
@endsection
