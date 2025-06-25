<!-- @extends('admin.base.base')

@section('page_title', 'Create Account')

@section('main_content')
<div class="container mt-4">
    <h2>Create New Account</h2>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="form-group mb-2">
            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
        </div>
        <div class="form-group mb-2">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
        </div>
        <div class="form-group mb-2">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group mb-2">
            <select name="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="1">Admin</option>
                <option value="2">Staff</option>
                <option value="3">User</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group mb-2">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection  -->