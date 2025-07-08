@extends('admin.base.base')

@section('page_title', 'Accounts')

@section('main_content')
<div class="container-fluid px-4">
    <div class="card my-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0">Manage Accounts</h3>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#addAccountModal">
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
                            <div class="col-md-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required maxlength="50" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)">
                            </div>
                            <div class="col-md-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" id="middle_name" name="middle_name" class="form-control" maxlength="50" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)">
                            </div>
                            <div class="col-md-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required maxlength="50" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)">
                            </div>
                            <div class="col-md-3">
                                <label for="suffix" class="form-label">Suffix</label>
                                <select id="suffix" name="suffix" class="form-control">
                                    <option value="">-- None --</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="birth_date" class="form-label">Birth Date *</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-control" required onchange="validateAge()">
                                <div id="ageWarning" class="hidden text-danger text-sm mt-1">You must be at least 18 years old to register.</div>
                            </div>
                            <div class="col-md-3">
                                <label for="sex" class="form-label">Sex *</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="phone_number" class="form-label">Phone Number *</label>
                                <input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="09XXXXXXXXX" pattern="09[0-9]{9}" maxlength="11" required oninput="sanitizePhone(this)">
                            </div>
                            <div class="col-md-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" id="email" name="email" class="form-control" required maxlength="255" oninput="sanitizeEmail(this)">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="place_of_birth" class="form-label">Place of Birth *</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" class="form-control" required maxlength="100" pattern="[A-Za-z\s,.-]+" oninput="sanitizeInput(this)">
                            </div>
                        </div>

                        <!-- Address Information -->
                        <h6 class="mt-4 mb-3">Address Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="region" class="form-label">Region *</label>
                                <select id="region" name="region" class="form-control" required>
                                    <option value="">Select Region</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="province" class="form-label">Province *</label>
                                <select id="province" name="province" class="form-control" required>
                                    <option value="">Select Province</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="city" class="form-label">City/Municipality *</label>
                                <select id="city" name="city" class="form-control" required>
                                    <option value="">Select City/Municipality</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay" class="form-label">Barangay *</label>
                                <select id="barangay" name="barangay" class="form-control" required>
                                    <option value="">Select Barangay</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="street_building_unit" class="form-label">Street/Building/Unit *</label>
                                <input type="text" id="street_building_unit" name="street_building_unit" class="form-control" required maxlength="200" pattern="[A-Za-z0-9\s,.-#]+" oninput="sanitizeInput(this)">
                            </div>
                            <div class="col-md-3">
                                <label for="zipcode" class="form-label">Zipcode *</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" required maxlength="10" pattern="[0-9]+" oninput="sanitizeZipcode(this)">
                            </div>
                        </div>

                        <!-- Account Information -->
                        <h6 class="mt-4 mb-3">Account Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="role" class="form-label">Role *</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">HR</option>
                                    <option value="3">User</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" name="password" id="password" class="form-control" required minlength="8" maxlength="255" oninput="validatePassword(this)" onfocus="showPasswordRequirements()" onblur="hidePasswordRequirements()">
                                <div id="password-requirements" class="text-xs mt-1 space-y-1 hidden">
                                    <div id="length-check" class="text-muted">• At least 8 characters</div>
                                    <div id="uppercase-check" class="text-muted">• One uppercase letter</div>
                                    <div id="number-check" class="text-muted">• One number</div>
                                    <div id="special-check" class="text-muted">• One Special character (.@$!%*?&)</div>
                                </div>
                                <div id="password-strength" class="text-xs mt-1 font-medium"></div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control pr-5" required minlength="8" maxlength="255" oninput="validateConfirmPassword(this)" onfocus="showPasswordMatch()" onblur="hidePasswordMatch()">
                                <button type="button" id="toggle-confirm-password" class="btn btn-link position-absolute top-50 end-0 translate-middle-y" tabindex="-1" onclick="toggleConfirmPasswordVisibility()">
                                    <i class="fas fa-eye" id="eye-open"></i>
                                    <i class="fas fa-eye-slash d-none" id="eye-closed"></i>
                                </button>
                                <div id="confirm-password-match" class="text-xs mt-1 font-medium d-none"></div>
                            </div>
                        </div>
                        <div class="form-group mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Account
                            </button>
                        </div>
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

@push('scripts')
<script src="{{ asset('js/components/AddressDropdowns.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let adminAddressDropdowns = null;
    $('#addAccountModal').on('shown.bs.modal', function () {
        alert('AddressDropdowns modal event fired!');
        if (adminAddressDropdowns) {
            adminAddressDropdowns.destroy();
        }
        adminAddressDropdowns = new AddressDropdowns({
            regionSelect: '#region',
            provinceSelect: '#province',
            citySelect: '#city',
            barangaySelect: '#barangay',
            loadingText: 'Loading...',
            placeholderText: 'Select...'
        });
        window.adminAddressDropdowns = adminAddressDropdowns;

        // Debug: Patch loadRegions to log results
        const origLoadRegions = adminAddressDropdowns.loadRegions.bind(adminAddressDropdowns);
        adminAddressDropdowns.loadRegions = async function() {
            console.log('Calling loadRegions...');
            try {
                await origLoadRegions();
                console.log('Regions loaded:', this.elements.region?.options.length);
            } catch (e) {
                console.error('Error loading regions:', e);
            }
        };
        // Call patched loadRegions immediately
        adminAddressDropdowns.loadRegions();
    });
});
</script>
@endpush

<script>
    // --- Validation JS from registration page ---
    function sanitizeInput(input) {
        let value = input.value;
        value = value.replace(/<[^>]*>/g, '');
        value = value.replace(/[<>"'&]/g, '');
        value = value.replace(/javascript:/gi, '');
        value = value.replace(/on\w+=/gi, '');
        input.value = value;
    }
    function sanitizeEmail(input) {
        let value = input.value;
        value = value.replace(/[^a-zA-Z0-9@._-]/g, '');
        input.value = value;
    }
    function sanitizePhone(input) {
        let value = input.value;
        value = value.replace(/[^0-9]/g, '');
        if (value.length > 0 && !value.startsWith('09')) {
            if (value.startsWith('9')) {
                value = '0' + value;
            } else {
                value = '09' + value;
            }
        }
        if (value.length > 11) {
            value = value.substring(0, 11);
        }
        if (value.length >= 2 && value.substring(0, 2) !== '09') {
            if (value.length > 0) {
                input.style.borderColor = '#ef4444';
                input.title = 'Phone number must start with 09 (Philippine mobile format)';
            }
        } else {
            input.style.borderColor = '';
            input.title = '';
        }
        input.value = value;
    }
    function sanitizeZipcode(input) {
        let value = input.value;
        value = value.replace(/[^0-9]/g, '');
        input.value = value;
    }
    function validatePassword(input) {
        let value = input.value;
        value = value.replace(/<[^>]*>/g, '');
        value = value.replace(/[<>"'&]/g, '');
        // Check for password requirements
        const hasUpperCase = /[A-Z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        const hasMinLength = value.length >= 8;
        const hasSpecialChar = /[.@$!%*?&]/.test(value);
        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');
        const strengthIndicator = document.getElementById('password-strength');
        if (lengthCheck) {
            if (hasMinLength) {
                lengthCheck.innerHTML = '✅ At least 8 characters';
                lengthCheck.className = 'text-green-600 font-medium';
            } else {
                lengthCheck.innerHTML = '• At least 8 characters';
                lengthCheck.className = 'text-gray-500';
            }
        }
        if (uppercaseCheck) {
            if (hasUpperCase) {
                uppercaseCheck.innerHTML = '✅ One uppercase letter';
                uppercaseCheck.className = 'text-green-600 font-medium';
            } else {
                uppercaseCheck.innerHTML = '• One uppercase letter';
                uppercaseCheck.className = 'text-gray-500';
            }
        }
        if (numberCheck) {
            if (hasNumber) {
                numberCheck.innerHTML = '✅ One number';
                numberCheck.className = 'text-green-600 font-medium';
            } else {
                numberCheck.innerHTML = '• One number';
                numberCheck.className = 'text-gray-500';
            }
        }
        if (specialCheck) {
            if (hasSpecialChar) {
                specialCheck.innerHTML = '✅ One Special character (.@$!%*?&)';
                specialCheck.className = 'text-green-600 font-medium';
            } else {
                specialCheck.innerHTML = '• One Special character (.@$!%*?&)';
                specialCheck.className = 'text-gray-500';
            }
        }
        let strength = 0;
        if (hasMinLength) strength++;
        if (hasUpperCase) strength++;
        if (hasNumber) strength++;
        if (hasSpecialChar) strength++;
        if (strengthIndicator) {
            if (value.length === 0) {
                strengthIndicator.innerHTML = '';
                strengthIndicator.className = 'text-xs mt-1 font-medium';
            } else if (strength === 4) {
                strengthIndicator.innerHTML = '🔒 Strong Password';
                strengthIndicator.className = 'text-xs mt-1 font-medium text-green-600';
            } else if (strength >= 2) {
                strengthIndicator.innerHTML = '⚠️ Medium Password';
                strengthIndicator.className = 'text-xs mt-1 font-medium text-yellow-600';
            } else {
                strengthIndicator.innerHTML = '❌ Weak Password';
                strengthIndicator.className = 'text-xs mt-1 font-medium text-red-600';
            }
        }
        if (value.length > 0) {
            if (hasUpperCase && hasNumber && hasMinLength && hasSpecialChar) {
                input.style.borderColor = '#10b981';
                input.title = 'Password meets all requirements';
            } else {
                input.style.borderColor = '#f59e0b';
                let missingRequirements = [];
                if (!hasMinLength) missingRequirements.push('at least 8 characters');
                if (!hasUpperCase) missingRequirements.push('one uppercase letter');
                if (!hasNumber) missingRequirements.push('one number');
                if (!hasSpecialChar) missingRequirements.push('one special character (.@$!%*?&)');
                input.title = 'Missing: ' + missingRequirements.join(', ');
            }
        } else {
            input.style.borderColor = '';
            input.title = '';
        }
        input.value = value;
    }
    function validateConfirmPassword(input) {
        const passwordInput = document.getElementById('password');
        const confirmPasswordMatch = document.getElementById('confirm-password-match');
        let value = input.value;
        value = value.replace(/<[^>]*>/g, '');
        value = value.replace(/[<>"'&]/g, '');
        input.value = value;
        if (passwordInput && confirmPasswordMatch) {
            if (passwordInput.value === value) {
                confirmPasswordMatch.innerHTML = '✅ Passwords match';
                confirmPasswordMatch.className = 'text-xs mt-1 font-medium text-green-600';
                input.style.borderColor = '#10b981';
            } else if (value.length > 0) {
                confirmPasswordMatch.innerHTML = '❌ Passwords do not match';
                confirmPasswordMatch.className = 'text-xs mt-1 font-medium text-red-600';
                input.style.borderColor = '#ef4444';
            } else {
                confirmPasswordMatch.innerHTML = '';
                confirmPasswordMatch.className = 'text-xs mt-1 font-medium';
                input.style.borderColor = '';
            }
        }
    }
    function validateAge() {
        const birthDateInput = document.getElementById("birth_date");
        const birthDate = new Date(birthDateInput.value);
        const warning = document.getElementById("ageWarning");
        if (isNaN(birthDate.getTime())) {
            warning.classList.add("hidden");
            return;
        }
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18) {
            warning.classList.remove("hidden");
        } else {
            warning.classList.add("hidden");
        }
    }
    function showPasswordRequirements() {
        const requirements = document.getElementById('password-requirements');
        if (requirements) requirements.classList.remove('hidden');
    }
    function hidePasswordRequirements() {
        const requirements = document.getElementById('password-requirements');
        const passwordInput = document.getElementById('password');
        if (requirements && passwordInput && passwordInput.value.length === 0) {
            requirements.classList.add('hidden');
        }
    }
    function showPasswordMatch() {
        const match = document.getElementById('confirm-password-match');
        if (match) match.classList.remove('d-none', 'hidden');
    }
    function hidePasswordMatch() {
        const match = document.getElementById('confirm-password-match');
        if (match) match.classList.add('d-none', 'hidden');
    }
    function toggleConfirmPasswordVisibility() {
        const confirmInput = document.getElementById('password_confirmation');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        if (confirmInput.type === 'password') {
            confirmInput.type = 'text';
            if (eyeOpen) eyeOpen.classList.add('d-none');
            if (eyeClosed) eyeClosed.classList.remove('d-none');
        } else {
            confirmInput.type = 'password';
            if (eyeOpen) eyeOpen.classList.remove('d-none');
            if (eyeClosed) eyeClosed.classList.add('d-none');
        }
    }
</script> 