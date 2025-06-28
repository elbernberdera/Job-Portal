@extends('user.base.base')

@section('main_content')
<!-- SweetAlert2 for session success/error -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        };
    </script>
@endif
@if($errors->any())
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '{!! implode("<br>", $errors->all()) !!}'
            });
        };
    </script>
@endif
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    <h2 class="mb-0">Update Profile</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.update') }}">
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