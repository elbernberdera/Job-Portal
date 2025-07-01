@extends('admin.base.base')

@section('page_title', 'Job Positions Management')

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Job Positions Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Job Positions</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Job Positions</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.job_positions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Job Position
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="jobPositionsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">
                            <i class="fas fa-list"></i> Job Positions List
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="false">
                            <i class="fas fa-chart-bar"></i> Statistics
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="jobPositionsTabsContent">
                    <!-- List Tab -->
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Job Title</th>
                                <th>Position Code</th>
                                <th>Division</th>
                                <th>Region</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Date Posted</th>
                                <th>Applications</th>
                                <th>Gender (M/F)</th>
                                <th>Qualified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobPositions as $position)
                                <tr>
                                    <td>{{ $position->id }}</td>
                                    <td>{{ $position->job_title }}</td>
                                    <td>{{ $position->position_code }}</td>
                                    <td>{{ $position->division }}</td>
                                    <td>{{ $position->region }}</td>
                                    <td>
                                        <span class="badge badge-{{ $position->status === 'open' ? 'success' : ($position->status === 'closed' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($position->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($position->admin)
                                            <span class="badge badge-info">Admin: {{ $position->admin->first_name }} {{ $position->admin->last_name }}</span>
                                        @elseif($position->hr)
                                            <span class="badge badge-primary">HR: {{ $position->hr->first_name }} {{ $position->hr->last_name }}</span>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{ $position->date_posted ? $position->date_posted->format('M d, Y') : 'Not set' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $position->jobApplications->count() }}</span>
                                    </td>
                                    <td>
                                        @if($position->gender_stats['total'] > 0)
                                            <span class="badge badge-primary">{{ $position->gender_stats['male'] }}</span> / 
                                            <span class="badge badge-info">{{ $position->gender_stats['female'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($position->qualification_stats['total'] > 0)
                                            <span class="badge badge-success">{{ $position->qualification_stats['qualified'] }}</span> / 
                                            <span class="badge badge-warning">{{ $position->qualification_stats['not_qualified'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.job_positions.show', $position->id) }}" 
                                               class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.job_positions.statistics', $position->id) }}" 
                                               class="btn btn-primary btn-sm" title="View Statistics">
                                                <i class="fas fa-chart-bar"></i>
                                            </a>
                                            <a href="{{ route('admin.job_positions.edit', $position->id) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($position->status !== 'archived')
                                                <form action="{{ route('admin.job_positions.archive', $position->id) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm" 
                                                            title="Archive" onclick="return confirm('Are you sure you want to archive this job position?')">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.job_positions.restore', $position->id) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" 
                                                            title="Restore" onclick="return confirm('Are you sure you want to restore this job position?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.job_positions.destroy', $position->id) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        title="Delete" onclick="return confirm('Are you sure you want to delete this job position? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No job positions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                    </div>

                    <!-- Statistics Tab -->
                    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                        <div class="row">
                            @foreach($jobPositions as $position)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">{{ $position->job_title }}</h6>
                                            <small class="text-muted">{{ $position->position_code }}</small>
                                        </div>
                                        <div class="card-body">
                                            <!-- Gender Distribution -->
                                            <div class="mb-3">
                                                <h6 class="text-primary">
                                                    <i class="fas fa-users"></i> Gender Distribution
                                                </h6>
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <div class="bg-primary text-white rounded p-2 mb-2">
                                                            <h4 class="mb-0">{{ $position->gender_stats['male'] }}</h4>
                                                            <small>Male</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-info text-white rounded p-2 mb-2">
                                                            <h4 class="mb-0">{{ $position->gender_stats['female'] }}</h4>
                                                            <small>Female</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress mb-2">
                                                    @if($position->gender_stats['total'] > 0)
                                                        <div class="progress-bar bg-primary" style="width: {{ ($position->gender_stats['male'] / $position->gender_stats['total']) * 100 }}%"></div>
                                                        <div class="progress-bar bg-info" style="width: {{ ($position->gender_stats['female'] / $position->gender_stats['total']) * 100 }}%"></div>
                                                    @endif
                                                </div>
                                                <small class="text-muted">Total: {{ $position->gender_stats['total'] }} applicants</small>
                                            </div>

                                            <!-- Qualification Status -->
                                            <div class="mb-3">
                                                <h6 class="text-success">
                                                    <i class="fas fa-check-circle"></i> Qualification Status
                                                </h6>
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <div class="bg-success text-white rounded p-2 mb-2">
                                                            <h4 class="mb-0">{{ $position->qualification_stats['qualified'] }}</h4>
                                                            <small>Passer</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-warning text-white rounded p-2 mb-2">
                                                            <h4 class="mb-0">{{ $position->qualification_stats['not_qualified'] }}</h4>
                                                            <small>Not Passer</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress mb-2">
                                                    @if($position->qualification_stats['total'] > 0)
                                                        <div class="progress-bar bg-success" style="width: {{ ($position->qualification_stats['qualified'] / $position->qualification_stats['total']) * 100 }}%"></div>
                                                        <div class="progress-bar bg-warning" style="width: {{ ($position->qualification_stats['not_qualified'] / $position->qualification_stats['total']) * 100 }}%"></div>
                                                    @endif
                                                </div>
                                                <small class="text-muted">Total: {{ $position->qualification_stats['total'] }} applicants</small>
                                            </div>

                                            <!-- Summary -->
                                            <div class="text-center">
                                                <span class="badge badge-{{ $position->status === 'open' ? 'success' : ($position->status === 'closed' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($position->status) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    Created by: 
                                                    @if($position->admin)
                                                        Admin: {{ $position->admin->first_name }} {{ $position->admin->last_name }}
                                                    @elseif($position->hr)
                                                        HR: {{ $position->hr->first_name }} {{ $position->hr->last_name }}
                                                    @else
                                                        Unknown
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($jobPositions->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No job positions found</h5>
                                <p class="text-muted">Create job positions to see statistics</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .btn-group .btn {
        margin-right: 2px;
    }
    .table th {
        background-color: #f4f6f9;
    }
    
    .progress {
        height: 8px;
    }
    
    .card-body .bg-primary,
    .card-body .bg-info,
    .card-body .bg-success,
    .card-body .bg-warning {
        transition: transform 0.2s;
    }
    
    .card-body .bg-primary:hover,
    .card-body .bg-info:hover,
    .card-body .bg-success:hover,
    .card-body .bg-warning:hover {
        transform: scale(1.05);
    }
    
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #007bff;
        background: none;
        color: #007bff;
    }
</style>
@endsection 