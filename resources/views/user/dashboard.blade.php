@extends('user.base.base')

@php
    $recentApplications = $recentApplications ?? collect();
    $statusCounts = $statusCounts ?? [];
    $profileCompletion = $profileCompletion ?? 0;
    $userEvents = $userEvents ?? collect();
@endphp

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <!-- Breadcrumb or other header content can go here -->
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Open Jobs -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $openJobs ?? 0 }}</h3>
                        <p>Open Job Vacancies</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Applied -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $appliedJobs ?? 0 }}</h3>
                        <p>Jobs You've Applied For</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Failed -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $failedJobs ?? 0 }}</h3>
                        <p>Applications Failed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Application Status Breakdown -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Application Status Breakdown</div>
                    <div class="card-body">
                        <ul>
                            <li>Under Review: {{ $statusCounts['under_review'] ?? 0 }}</li>
                            <li>Shortlisted: {{ $statusCounts['shortlisted'] ?? 0 }}</li>
                            <li>Rejected: {{ $statusCounts['rejected'] ?? 0 }}</li>
                            <li>Hired: {{ $statusCounts['hired'] ?? 0 }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Recent Applications -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recent Applications</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Date Applied</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentApplications as $app)
                                    <tr>
                                        <td>{{ $app->jobVacancy->title ?? 'N/A' }}</td>
                                        <td>{{ $app->created_at->format('Y-m-d') }}</td>
                                        <td>{{ ucfirst($app->status) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3">No recent applications.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       

        <!-- User Calendar Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Calendar</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Event Type</th>
                                    <th>Job Title</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userEvents as $event)
                                    <tr>
                                        <td>{{ $event['type'] }}</td>
                                        <td>{{ $event['job'] }}</td>
                                        <td>{{ $event['date'] }}</td>
                                        <td>{{ $event['status'] }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">No events found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


         <!-- Profile Completion -->
         <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile Completion</div>
                    <div class="card-body">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $profileCompletion }}%;" aria-valuenow="{{ $profileCompletion }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $profileCompletion }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      


            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
                    </div>
                    <div class="card-body">
                        second box
                    </div>
                </div>
            </div> -->


        </div>

        
    </div>
</div>
@endsection
