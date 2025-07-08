@extends('admin.base.base')

@section('title', 'Site Configuration')

@section('main_content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">⚙️ Site Configuration</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Site Configuration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">General Settings</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.site-config.update') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                                   id="site_name" name="site_name" 
                                                   value="{{ old('site_name', $settings['site_name']) }}" required>
                                            @error('site_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_email">Contact Email</label>
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                                   id="contact_email" name="contact_email" 
                                                   value="{{ old('contact_email', $settings['contact_email']) }}" required>
                                            @error('contact_email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                              id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
                                    @error('site_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <hr>

                                <h5>System Settings</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="maintenance_mode" name="maintenance_mode" 
                                                       {{ old('maintenance_mode', $settings['maintenance_mode'] == '1' || $settings['maintenance_mode'] === true) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="maintenance_mode">
                                                    Maintenance Mode
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                When enabled, only administrators can access the site
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="notification_enabled" name="notification_enabled" 
                                                       {{ old('notification_enabled', $settings['notification_enabled'] == '1' || $settings['notification_enabled'] === true) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="notification_enabled">
                                                    Enable Notifications
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Enable email notifications for users
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="job_approval_required" name="job_approval_required" 
                                                       {{ old('job_approval_required', $settings['job_approval_required'] == '1' || $settings['job_approval_required'] === true) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="job_approval_required">
                                                    Job Approval Required
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Require admin approval for new job postings
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h5>Job Settings</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_job_applications">Max Job Applications per User</label>
                                            <input type="number" class="form-control @error('max_job_applications') is-invalid @enderror" 
                                                   id="max_job_applications" name="max_job_applications" 
                                                   value="{{ old('max_job_applications', $settings['max_job_applications']) }}" 
                                                   min="1" max="20" required>
                                            @error('max_job_applications')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="auto_archive_days">Auto Archive Days</label>
                                            <input type="number" class="form-control @error('auto_archive_days') is-invalid @enderror" 
                                                   id="auto_archive_days" name="auto_archive_days" 
                                                   value="{{ old('auto_archive_days', $settings['auto_archive_days']) }}" 
                                                   min="1" max="365" required>
                                            @error('auto_archive_days')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Days after which expired jobs are automatically archived
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Configuration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="{{ route('admin.job-categories') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-tags"></i> Manage Job Categories
                                </a>
                                <a href="{{ route('admin.locations') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-map-marker-alt"></i> Manage Locations
                                </a>
                                <a href="{{ route('admin.industries') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-industry"></i> Manage Industries
                                </a>
                                <a href="{{ route('admin.logs') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-clipboard-list"></i> View System Logs
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">System Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Laravel Version:</strong></td>
                                    <td>{{ app()->version() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>PHP Version:</strong></td>
                                    <td>{{ phpversion() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Database:</strong></td>
                                    <td>{{ config('database.default') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Environment:</strong></td>
                                    <td>{{ config('app.env') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 