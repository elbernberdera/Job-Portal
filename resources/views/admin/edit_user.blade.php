@extends('admin.base.base')

@section('page_title', 'Edit Account')

@section('main_content')
<div class="container mt-4">
    <h2>Edit Account</h2>
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group mb-2">
            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
        </div>
        <div class="form-group mb-2">
            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
        </div>
        <div class="form-group mb-2">
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group mb-2">
            <select name="role" class="form-control" required>
                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Staff</option>
                <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection 