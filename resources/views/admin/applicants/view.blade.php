@extends('admin.base.base')

@section('page_title')
    View Applicant - {{ $user->first_name }} {{ $user->last_name }}
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applicant Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.applicants') }}">Applicants</a></li>
                    <li class="breadcrumb-item active">View Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Information -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            <div class="mb-2">
                                @if($user->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="profile-info">
                            <div class="info-item">
                                <strong>Phone:</strong> {{ $user->phone_number }}
                            </div>
                            <div class="info-item">
                                <strong>Birth Date:</strong> {{ $user->birth_date->format('M d, Y') }} ({{ $user->birth_date->age }} years old)
                            </div>
                            <div class="info-item">
                                <strong>Gender:</strong> {{ ucfirst($user->sex) }}
                            </div>
                            <div class="info-item">
                                <strong>Place of Birth:</strong> {{ $user->place_of_birth }}
                            </div>
                            <div class="info-item">
                                <strong>Registered:</strong> {{ $user->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <div class="btn-group" role="group">
                                @if($user->is_active)
                                    <form action="{{ route('admin.applicants.deactivate', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-pause"></i> Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.applicants.activate', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-play"></i> Activate
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.applicants.delete', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this applicant?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Address Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="address-info">
                            <div class="info-item">
                                <strong>Region:</strong> {{ $user->region }}
                            </div>
                            <div class="info-item">
                                <strong>Province:</strong> {{ $user->province }}
                            </div>
                            <div class="info-item">
                                <strong>City:</strong> {{ $user->city }}
                            </div>
                            <div class="info-item">
                                <strong>Barangay:</strong> {{ $user->barangay }}
                            </div>
                            <div class="info-item">
                                <strong>Street/Building:</strong> {{ $user->street_building_unit }}
                            </div>
                            <div class="info-item">
                                <strong>Zip Code:</strong> {{ $user->zipcode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Applications -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Job Applications ({{ $user->jobApplications->count() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        @if($user->jobApplications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->jobApplications as $application)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold">{{ $application->jobVacancy->position_title }}</div>
                                                <small class="text-muted">{{ $application->jobVacancy->company_name ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if(in_array($application->status, ['shortlisted', 'interviewed', 'offered', 'hired']))
                                                    <span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                                @elseif(in_array($application->status, ['applied', 'under_review']))
                                                    <span class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-info">View Details</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-file-alt fa-2x mb-3"></i>
                                <p>No job applications found</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resume/Profile Information -->
                @if($user->profile)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Resume Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Education</h5>
                                @if($user->profile->education)
                                    <div class="education-item">
                                        <strong>{{ $user->profile->education->degree ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $user->profile->education->school ?? 'N/A' }}</small>
                                    </div>
                                @else
                                    <p class="text-muted">No education information available</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>Experience</h5>
                                @if($user->profile->experience)
                                    <div class="experience-item">
                                        <strong>{{ $user->profile->experience->position ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $user->profile->experience->company ?? 'N/A' }}</small>
                                    </div>
                                @else
                                    <p class="text-muted">No experience information available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
    
    .profile-info .info-item,
    .address-info .info-item {
        margin-bottom: 8px;
        padding: 4px 0;
    }
    
    .education-item,
    .experience-item {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection 