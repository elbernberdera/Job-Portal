@extends('admin.base.base')

@section('title', 'Industries Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">🏭 Industries Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Industries</li>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Industry</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.industries.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Industry Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="is_active" name="is_active" checked>
                                        <label class="custom-control-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Industry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Industries</h3>
                            <div class="card-tools">
                                <form action="{{ route('admin.industries') }}" method="GET" class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control float-right" 
                                           placeholder="Search industries..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($industries->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Jobs Count</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($industries as $industry)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $industry->name }}</strong>
                                                    </td>
                                                    <td>
                                                        {{ Str::limit($industry->description, 50) }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $industry->job_vacancies_count }}</span>
                                                    </td>
                                                    <td>
                                                        @if($industry->is_active)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" 
                                                                data-toggle="modal" data-target="#editModal{{ $industry->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @if($industry->job_vacancies_count == 0)
                                                            <form action="{{ route('admin.industries.delete', $industry->id) }}" 
                                                                  method="POST" class="d-inline" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this industry?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-danger" disabled 
                                                                    title="Cannot delete industry with associated jobs">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal{{ $industry->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Industry</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('admin.industries.update', $industry->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="edit_name_{{ $industry->id }}">Industry Name</label>
                                                                        <input type="text" class="form-control" 
                                                                               id="edit_name_{{ $industry->id }}" name="name" 
                                                                               value="{{ $industry->name }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="edit_description_{{ $industry->id }}">Description</label>
                                                                        <textarea class="form-control" 
                                                                                  id="edit_description_{{ $industry->id }}" name="description" 
                                                                                  rows="3">{{ $industry->description }}</textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="edit_is_active_{{ $industry->id }}" name="is_active" 
                                                                                   {{ $industry->is_active ? 'checked' : '' }}>
                                                                            <label class="custom-control-label" for="edit_is_active_{{ $industry->id }}">
                                                                                Active
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Industry</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center">
                                    {{ $industries->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-industry fa-3x text-muted mb-3"></i>
                                    <h5>No industries found</h5>
                                    <p class="text-muted">Start by adding your first industry.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 