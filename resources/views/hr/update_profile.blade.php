@extends('hr.base.base')

@section('main_content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    <h2 class="mb-0">Update Profile</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('hr.profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', Auth::user()->last_name) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New Password">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection