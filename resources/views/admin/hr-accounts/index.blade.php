@extends('admin.base.base')

@section('page_title')
    HR Accounts Management
@endsection

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">HR Accounts Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">HR Accounts</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Search and Filter Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Search & Filter</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.hr-accounts') }}" class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Name, email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="approval_status">Approval Status</label>
                            <select class="form-control" id="approval_status" name="approval_status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Account Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.hr-accounts') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- HR Accounts Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HR Accounts ({{ $hrAccounts->total() }} total)</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Jobs Posted</th>
                                <th>Approval Status</th>
                                <th>Account Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hrAccounts as $hrAccount)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center mr-2">
                                            <i class="fas fa-user-tie text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $hrAccount->first_name }} {{ $hrAccount->last_name }}</div>
                                            <small class="text-muted">{{ $hrAccount->sex }} • {{ $hrAccount->birth_date->age }} years old</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $hrAccount->email }}</td>
                                <td>{{ $hrAccount->phone_number }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $hrAccount->jobVacancies->count() }}</span>
                                </td>
                                <td>
                                    @if($hrAccount->is_approved)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($hrAccount->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $hrAccount->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.hr-accounts.activity', $hrAccount) }}" 
                                           class="btn btn-sm btn-outline-info" title="View Activity">
                                            <i class="fas fa-chart-line"></i>
                                        </a>
                                        
                                        @if(!$hrAccount->is_approved)
                                            <form action="{{ route('admin.hr-accounts.approve', $hrAccount) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        title="Approve" onclick="return confirm('Approve this HR account?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.hr-accounts.reject', $hrAccount) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                        title="Reject" onclick="return confirm('Reject this HR account?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($hrAccount->is_active)
                                            <form action="{{ route('admin.hr-accounts.deactivate', $hrAccount) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                        title="Deactivate" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.hr-accounts.activate', $hrAccount) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        title="Activate">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.hr-accounts.delete', $hrAccount) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    title="Delete" onclick="return confirm('Are you sure you want to delete this HR account?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-user-tie fa-2x mb-3"></i>
                                    <p>No HR accounts found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $hrAccounts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@endsection 