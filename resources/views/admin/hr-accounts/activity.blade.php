@extends('admin.base.base')

@section('page_title')
    HR Activity - {{ $user->first_name }} {{ $user->last_name }}
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">HR Activity Log</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hr-accounts') }}">HR Accounts</a></li>
                    <li class="breadcrumb-item active">Activity</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- HR Profile Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">HR Profile Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                        <i class="fas fa-user-tie fa-3x text-muted"></i>
                                    </div>
                                    <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-briefcase"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Jobs Posted</span>
                                                <span class="info-box-number">{{ $postedJobs->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Hired Users</span>
                                                <span class="info-box-number">{{ $hiredUsers->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Member Since</span>
                                                <span class="info-box-number">{{ $user->created_at->format('M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Posted Jobs -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Posted Jobs ({{ $postedJobs->count() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        @if($postedJobs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Applications</th>
                                            <th>Posted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($postedJobs as $job)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold">{{ $job->position_title }}</div>
                                                <small class="text-muted">{{ $job->company_name ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($job->status === 'open')
                                                    <span class="badge badge-success">Open</span>
                                                @elseif($job->status === 'closed')
                                                    <span class="badge badge-danger">Closed</span>
                                                @else
                                                    <span class="badge badge-warning">{{ ucfirst($job->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $job->applications->count() }}</span>
                                            </td>
                                            <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-briefcase fa-2x mb-3"></i>
                                <p>No jobs posted yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hired Users -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Hired Users ({{ $hiredUsers->count() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        @if($hiredUsers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Applicant</th>
                                            <th>Position</th>
                                            <th>Hired Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hiredUsers as $application)
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
                                            <td>
                                                <div class="font-weight-bold">{{ $application->jobVacancy->position_title }}</div>
                                                <small class="text-muted">{{ $application->jobVacancy->company_name ?? 'N/A' }}</small>
                                            </td>
                                            <td>{{ $application->updated_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <p>No users hired yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Timeline -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activity Timeline</h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @php
                                $activities = collect();
                                
                                // Add job postings
                                foreach($postedJobs->take(5) as $job) {
                                    $activities->push([
                                        'type' => 'job_posted',
                                        'title' => 'Posted job: ' . $job->position_title,
                                        'date' => $job->created_at,
                                        'icon' => 'fas fa-briefcase',
                                        'color' => 'bg-blue'
                                    ]);
                                }
                                
                                // Add hirings
                                foreach($hiredUsers->take(5) as $hiring) {
                                    $activities->push([
                                        'type' => 'user_hired',
                                        'title' => 'Hired: ' . $hiring->user->first_name . ' ' . $hiring->user->last_name,
                                        'date' => $hiring->updated_at,
                                        'icon' => 'fas fa-user-check',
                                        'color' => 'bg-green'
                                    ]);
                                }
                                
                                // Sort by date
                                $activities = $activities->sortByDesc('date')->take(10);
                            @endphp
                            
                            @forelse($activities as $activity)
                                <div class="time-label">
                                    <span class="{{ $activity['color'] }}">{{ $activity['date']->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <i class="{{ $activity['icon'] }} {{ $activity['color'] }}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $activity['date']->format('g:i A') }}</span>
                                        <h3 class="timeline-header">{{ $activity['title'] }}</h3>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-history fa-2x mb-3"></i>
                                    <p>No recent activity</p>
                                </div>
                            @endforelse
                            
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
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
    .avatar-lg {
        width: 80px;
        height: 80px;
        font-size: 32px;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
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
    
    .timeline {
        position: relative;
        margin: 0 0 30px 0;
        padding: 0;
        list-style: none;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #ddd;
        left: 31px;
        margin: 0;
        border-radius: 2px;
    }
    
    .timeline > div {
        position: relative;
        margin-right: 10px;
        margin-bottom: 15px;
    }
    
    .timeline > div > i {
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        position: absolute;
        color: #666;
        background: #dadada;
        border-radius: 50%;
        text-align: center;
        left: 18px;
        top: 0;
    }
    
    .timeline-item {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: 0.25rem;
        background-color: #fff;
        color: #495057;
        margin-left: 60px;
        margin-top: 0;
        margin-bottom: 0;
        margin-right: 0;
        position: relative;
    }
    
    .timeline-header {
        color: #495057;
        font-size: 16px;
        line-height: 1.1;
        margin: 0;
        padding: 10px;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .timeline .time {
        color: #999;
        font-size: 12px;
        padding: 10px;
        display: block;
    }
    
    .time-label {
        border-radius: 0.25rem;
        background-color: #fff;
        color: #495057;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        margin-left: 60px;
        margin-bottom: 15px;
        position: relative;
    }
    
    .time-label span {
        border-radius: 0.25rem;
        color: #fff;
        display: block;
        padding: 5px 10px;
    }
</style>
@endsection 