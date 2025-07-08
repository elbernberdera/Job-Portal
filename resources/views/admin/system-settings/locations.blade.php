@extends('admin.base.base')

@section('title', 'Locations Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">📍 Locations Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Locations</li>
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
                            <h3 class="card-title">Add New Location</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.locations.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Location Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" class="form-control @error('region') is-invalid @enderror" 
                                           id="region" name="region" value="{{ old('region') }}" required>
                                    @error('region')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                           id="province" name="province" value="{{ old('province') }}" required>
                                    @error('province')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}" required>
                                    @error('city')
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
                                    <i class="fas fa-plus"></i> Add Location
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Locations</h3>
                            <div class="card-tools">
                                <form action="{{ route('admin.locations') }}" method="GET" class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control float-right" 
                                           placeholder="Search locations..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($locations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Region</th>
                                                <th>Province</th>
                                                <th>City</th>
                                                <th>Jobs Count</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($locations as $location)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $location->name }}</strong>
                                                    </td>
                                                    <td>{{ $location->region }}</td>
                                                    <td>{{ $location->province }}</td>
                                                    <td>{{ $location->city }}</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $location->job_vacancies_count }}</span>
                                                    </td>
                                                    <td>
                                                        @if($location->is_active)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" 
                                                                data-toggle="modal" data-target="#editModal{{ $location->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @if($location->job_vacancies_count == 0)
                                                            <form action="{{ route('admin.locations.delete', $location->id) }}" 
                                                                  method="POST" class="d-inline" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this location?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-danger" disabled 
                                                                    title="Cannot delete location with associated jobs">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal{{ $location->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Location</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="edit_name_{{ $location->id }}">Location Name</label>
                                                                        <input type="text" class="form-control" 
                                                                               id="edit_name_{{ $location->id }}" name="name" 
                                                                               value="{{ $location->name }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="edit_region_{{ $location->id }}">Region</label>
                                                                        <input type="text" class="form-control" 
                                                                               id="edit_region_{{ $location->id }}" name="region" 
                                                                               value="{{ $location->region }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="edit_province_{{ $location->id }}">Province</label>
                                                                        <input type="text" class="form-control" 
                                                                               id="edit_province_{{ $location->id }}" name="province" 
                                                                               value="{{ $location->province }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="edit_city_{{ $location->id }}">City</label>
                                                                        <input type="text" class="form-control" 
                                                                               id="edit_city_{{ $location->id }}" name="city" 
                                                                               value="{{ $location->city }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" 
                                                                                   id="edit_is_active_{{ $location->id }}" name="is_active" 
                                                                                   {{ $location->is_active ? 'checked' : '' }}>
                                                                            <label class="custom-control-label" for="edit_is_active_{{ $location->id }}">
                                                                                Active
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Location</button>
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
                                    {{ $locations->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <h5>No locations found</h5>
                                    <p class="text-muted">Start by adding your first location.</p>
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