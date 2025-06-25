@extends('admin.base.base')

@section('page_title', 'Accounts')

@section('main_content')
<div class="container-fluid px-4">
    <div class="card my-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0">Manage Accounts</h3>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                        <i class="fas fa-plus"></i> Add New Account
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_Table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 1)
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role == 2)
                                        <span class="badge bg-primary">HR</span>
                                    @else
                                        <span class="badge bg-success">User</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-first-name="{{ $user->first_name }}"
                                            data-last-name="{{ $user->last_name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->first_name }} {{ $user->last_name }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Account Modal -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.accounts.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any() && session('modal') === 'add')
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Personal Information -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="middle_initial" class="form-label">Middle Initial</label>
                                <input type="text" name="middle_initial" class="form-control" maxlength="1">
                            </div>
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="birth_date" class="form-label">Birth Date *</label>
                                <input type="date" name="birth_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sex" class="form-label">Sex *</label>
                                <select name="sex" class="form-control" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="phone_number" class="form-label">Phone Number *</label>
                                <input type="tel" name="phone_number" class="form-control" placeholder="09XXXXXXXXX" pattern="^09\d{9}$" maxlength="11" required title="Please enter a valid Philippine mobile number (e.g., 09123456789)">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="place_of_birth" class="form-label">Place of Birth *</label>
                                <input type="text" name="place_of_birth" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="birth_date" class="form-label">Birth Date *</label>
                                <input type="date" name="birth_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <h6 class="mt-4 mb-3">Address Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="region" class="form-label">Region *</label>
                                <input type="text" name="region" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="province" class="form-label">Province *</label>
                                <input type="text" name="province" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="barangay" class="form-label">Barangay *</label>
                                <input type="text" name="barangay" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="street_building_unit" class="form-label">Street/Building/Unit *</label>
                                <input type="text" name="street_building_unit" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="zipcode" class="form-label">Zipcode *</label>
                                <input type="text" name="zipcode" class="form-control" required>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <h6 class="mt-4 mb-3">Account Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="role" class="form-label">Role *</label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">HR</option>
                                    <option value="3">User</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">At least 8 characters</small>
                            </div>
                            <div class="col-md-4">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="editUserModalLabel">Edit Account</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($errors->any() && session('modal') === 'edit')
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <input type="hidden" name="user_id" id="edit_user_id">
              <input type="text" name="first_name" id="edit_first_name" class="form-control mb-2" placeholder="First Name" required>
              <input type="text" name="last_name" id="edit_last_name" class="form-control mb-2" placeholder="Last Name" required>
              <input type="email" name="email" id="edit_email" class="form-control mb-2" placeholder="Email" required>
              <select name="role" id="edit_role" class="form-control mb-2" required>
                  <option value="1">Admin</option>
                  <option value="2">HR</option>
                  <option value="3">User</option>
              </select>
              <input type="password" name="password" id="edit_password" class="form-control mb-2" placeholder="New Password (optional)">
              <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control mb-2" placeholder="Confirm New Password">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="deleteUserForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
              <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($errors->any() && session('modal') === 'delete')
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <p>Are you sure you want to delete user: <strong id="delete_username"></strong>?</p>
              <input type="hidden" name="user_id" id="delete_user_id">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>


<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function () {
            $('#user_Table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                     'pdf', 'print'
                ],
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']]
            });
        
    });
    
</script>

@endsection

@section('custom_css')
<style>
    .btn-group {
        gap: 5px;
    }
    .card-header {
        background-color: #f8f9fa;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 85%;
    }
</style>
@endsection

@section('custom_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit button
    document.querySelectorAll('.btn-warning[data-bs-target="#editUserModal"]').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('edit_user_id').value = this.getAttribute('data-user-id');
            document.getElementById('edit_first_name').value = this.getAttribute('data-first-name');
            document.getElementById('edit_last_name').value = this.getAttribute('data-last-name');
            document.getElementById('edit_email').value = this.getAttribute('data-email');
            document.getElementById('edit_role').value = this.getAttribute('data-role');
            document.getElementById('editUserForm').action = '/admin/accounts/' + this.getAttribute('data-user-id');
        });
    });

    // Delete button
    document.querySelectorAll('.btn-danger[data-bs-target="#deleteUserModal"]').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('delete_user_id').value = this.getAttribute('data-user-id');
            document.getElementById('delete_username').textContent = this.getAttribute('data-user-name');
            document.getElementById('deleteUserForm').action = '/admin/accounts/' + this.getAttribute('data-user-id');
        });
    });
});
</script>
@endsection 