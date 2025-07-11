@extends('user.base.base')

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

<script>
function saveSection(sectionId, callback) {
    const formData = new FormData(document.getElementById('profileForm'));
    formData.append('section', sectionId);
    fetch("{{ route('user.profile.saveSection') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && typeof callback === 'function') {
            callback();
        }
    });
}

function showSection(sectionId) {
    // Save current section before switching
    const currentSection = document.querySelector('.content:not([style*="display: none"])');
    if (currentSection) {
        saveSection(currentSection.id, function() {
            // Hide all sections
            document.querySelectorAll('.content').forEach(el => el.style.display = 'none');
            // Show the selected section
            document.getElementById(sectionId).style.display = '';
        });
    } else {
        // Hide all sections
        document.querySelectorAll('.content').forEach(el => el.style.display = 'none');
        // Show the selected section
        document.getElementById(sectionId).style.display = '';
    }
}


// On page load, ensure only visible section has required fields
window.addEventListener('DOMContentLoaded', function() {
    var sections = document.querySelectorAll('.content');
    sections.forEach(function(section) {
        if (section.style.display === 'none') {
            section.querySelectorAll('[required]').forEach(function(input) {
                input.dataset.required = 'true';
                input.removeAttribute('required');
            });
        }
    });
    var visible = document.querySelector('.content:not([style*="display: none"])');
    if (visible) {
        visible.querySelectorAll('[data-required="true"]').forEach(function(input) {
            input.setAttribute('required', 'required');
        });
    }
});
</script>

@section('main_content')

@push('styles')
<link href="{{ asset('assets/static/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

<style>
    .nav-tabs .nav-link {
        color: black;
        border: 1px solid transparent; /* default border */
    }

    .nav-tabs .nav-link.active {
        color: blue !important;
        border: 1px solid blue !important; /* blue border */
        border-bottom-color: transparent !important; /* to blend with the tab content below */
        background-color: white !important; /* optional for contrast */
    }

    /* Show only short label by default */
    .nav-link .full-title {
        display: none;
    }

    .nav-link .short-title {
        display: inline;
    }

    /* When active, hide short title and show full title */
    .nav-link.active .short-title {
        display: none;
    }

    .nav-link.active .full-title {
        display: inline;
    }
</style>



<div class="container">
        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="tab-section1" data-bs-toggle="tab" data-bs-target="#section1" type="button" role="tab">
                    <span class="short-title">I.</span>
                    <span class="full-title">I. Personal Information</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tab-section2" data-bs-toggle="tab" data-bs-target="#section2" type="button" role="tab">
                    <span class="short-title">II.</span>
                    <span class="full-title">II. Family Background</span>
                </button>
        </li>
            <li class="nav-item">
                <button class="nav-link" id="tab-section3" data-bs-toggle="tab" data-bs-target="#section3" type="button" role="tab">
                    <span class="short-title">III.</span>
                    <span class="full-title">III. Educational Background</span>
                </button>
        </li>
            <li class="nav-item">
                <button class="nav-link" id="tab-section4" data-bs-toggle="tab" data-bs-target="#section4" type="button" role="tab">
                    <span class="short-title">IV.</span>
                    <span class="full-title">IV. Civil Service Eligibility</span>
                </button>
        </li>
    </ul>
</div>

<form id="profileForm">
    @csrf

<!-- section 1 -->
    
    <div class="tab-content">
        <div class="tab-pane fade show active" id="section1" role="tabpanel" aria-labelledby="tab-section1">
            <!-- Section 1 content -->
    <div class="container-fluid">
                <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">I. Personal Information</h3>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Surname/Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" 
                                   value="{{ old('last_name', $user->last_name) }}" 
                                   placeholder="Enter your surname" required>
                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" 
                                   value="{{ old('first_name', $user->first_name) }}" 
                                   placeholder="Enter your first name" required>
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                   id="middle_name" name="middle_name" 
                                   value="{{ old('middle_name', $user->middle_name) }}" 
                                   placeholder="Middle Name">
                            @error('middle_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="suffix">Suffix</label>
                            <select class="form-select @error('suffix') is-invalid @enderror" 
                                    id="suffix" name="suffix">
                                <option value="">Select Suffix</option>
                                <option value="Jr." {{ old('suffix', $user->suffix) == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ old('suffix', $user->suffix) == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="I" {{ old('suffix', $user->suffix) == 'I' ? 'selected' : '' }}>I</option>
                                <option value="II" {{ old('suffix', $user->suffix) == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ old('suffix', $user->suffix) == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ old('suffix', $user->suffix) == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V" {{ old('suffix', $user->suffix) == 'V' ? 'selected' : '' }}>V</option>
                            </select>
                            @error('suffix')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" 
                                   id="email" value="{{ $user->email }}" 
                                   readonly>
                            <small class="form-text text-muted">Email cannot be changed</small>
                        </div>
                    </div>

                    <!-- Date of birth and birth of place  -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="birth_date">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" 
                                   value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" required>
                            @error('birth_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="place_of_birth">Place of Birth <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" 
                                   id="place_of_birth" name="place_of_birth" 
                                   value="{{ old('place_of_birth', $user->place_of_birth) }}" required>
                            @error('place_of_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- sex and civil status -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sex">Sex <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="sex" name="sex">
                                <option value="">Select Sex</option>
                                <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('sex', $user->sex) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('sex')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="civil_status" name="civil_status" required>
                                <option value="">Select Status</option>
                                <option value="Single" {{ old('civil_status', $profile->civil_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status', $profile->civil_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status', $profile->civil_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status', $profile->civil_status ?? '') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="Divorced" {{ old('civil_status', $profile->civil_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            </select>
                            @error('civil_status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="height" class="form-label">Height (m) <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $profile->height ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required />
                        @error('height')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="weight" class="form-label">Weight (kg) <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $profile->weight ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                        @error('weight')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="blood_type" class="form-label">Blood Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="blood_type" name="blood_type">
                            <option value="">Select Blood Type</option>
                            <option value="A+" {{ old('blood_type', $profile->blood_type ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_type', $profile->blood_type ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_type', $profile->blood_type ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_type', $profile->blood_type ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('blood_type', $profile->blood_type ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_type', $profile->blood_type ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('blood_type', $profile->blood_type ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_type', $profile->blood_type ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('blood_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="gsis_id_no" class="form-label">GSIS ID No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('gsis_id_no') is-invalid @enderror" id="gsis_id_no" name="gsis_id_no" value="{{ old('gsis_id_no', $profile->gsis_id_no ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        @error('gsis_id_no')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="pagibig_id_no" class="form-label">PAG-IBIG ID No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('pagibig_id_no') is-invalid @enderror" id="pagibig_id_no" name="pagibig_id_no" value="{{ old('pagibig_id_no', $profile->pagibig_id_no ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        @error('pagibig_id_no')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="philhealth_no" class="form-label">PhilHealth No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('philhealth_no') is-invalid @enderror" id="philhealth_no" name="philhealth_no" value="{{ old('philhealth_no', $profile->philhealth_no ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" >
                        @error('philhealth_no')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="sss_no" class="form-label">SSS No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('sss_no') is-invalid @enderror" id="sss_no" name="sss_no" value="{{ old('sss_no', $profile->sss_no ?? '') }}" inputmode="decimal" pattern="^\d*\.?\d*$" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        @error('sss_no')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tin_no" class="form-label">TIN No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('tin_no') is-invalid @enderror" id="tin_no" name="tin_no" value="{{ old('tin_no', $profile->tin_no ?? '') }}" inputmode="decimal" pattern="^\d*\.?\d*$" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('tin_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="agency_employee_no" class="form-label">Agency Employee No. <span class="text-danger">*</span></label>
                        <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('agency_employee_no') is-invalid @enderror" id="agency_employee_no" name="agency_employee_no" value="{{ old('agency_employee_no', $profile->agency_employee_no ?? '') }}" inputmode="decimal" pattern="^\d*\.?\d*$" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('agency_employee_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="citizenship" class="form-label">Citizenship <span class="text-danger">*</span></label>
                            <select id="citizenship" name="citizenship" class="form-select" onchange="toggleDualDetails()">
                                <option value="">-- Select Citizenship --</option>
                            <option value="Filipino" {{ old('citizenship', $profile->citizenship ?? '') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                            <option value="Dual Citizenship by Birth" {{ old('citizenship', $profile->citizenship ?? '') == 'Dual Citizenship by Birth' ? 'selected' : '' }}>Dual Citizenship (By Birth)</option>
                            <option value="Dual Citizenship by Naturalization" {{ old('citizenship', $profile->citizenship ?? '') == 'Dual Citizenship by Naturalization' ? 'selected' : '' }}>Dual Citizenship (By Naturalization)</option>
                            <option value="Others" {{ old('citizenship', $profile->citizenship ?? '') == 'Others' ? 'selected' : '' }}>Others (Specify Country)</option>
                            </select>
                            @error('citizenship')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4" id="dualcitizinshipDropdown" >
                            <label for="dual_country_dropdown" class="form-label">Select Country:</label>
                            <select name="dual_country_dropdown" id="dual_country_dropdown" class="form-select">
                                <option value="">-- Select Country --</option>
                            <option value="Algeria" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                            <option value="Andorra" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                            <option value="Angola" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Angola' ? 'selected' : '' }}>Angola</option>
                            <option value="Antigua and Barbuda" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Antigua and Barbuda' ? 'selected' : '' }}>Antigua and Barbuda</option>
                            <option value="Argentina" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                            <option value="Armenia" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                            <option value="Aruba" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Aruba' ? 'selected' : '' }}>Aruba</option>
                            <option value="Australia" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <option value="Austria" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Austria' ? 'selected' : '' }}>Austria</option>
                            <option value="Azerbaijan" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                            <option value="Bahamas, The" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bahamas, The' ? 'selected' : '' }}>Bahamas, The</option>
                            <option value="Bahrain" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                            <option value="Bangladesh" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="Barbados" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                            <option value="Belarus" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                            <option value="Belgium" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                            <option value="Belize" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Belize' ? 'selected' : '' }}>Belize</option>
                            <option value="Benin" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Benin' ? 'selected' : '' }}>Benin</option>
                            <option value="Bhutan" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                            <option value="Bolivia" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                            <option value="Bosnia and Herzegovina" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                            <option value="Botswana" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                            <option value="Brazil" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                            <option value="Brunei" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
                            <option value="Bulgaria" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                            <option value="Burkina Faso" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                            <option value="Burma" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Burma' ? 'selected' : '' }}>Burma</option>
                            <option value="Burundi" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                            <option value="Cambodia" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                            <option value="Cameroon" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                            <option value="Canada" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Cape Verde" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Cape Verde' ? 'selected' : '' }}>Cape Verde</option>
                            <option value="Central African Republic" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Central African Republic' ? 'selected' : '' }}>Central African Republic</option>
                            <option value="Chad" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Chad' ? 'selected' : '' }}>Chad</option>
                            <option value="Chile" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Chile' ? 'selected' : '' }}>Chile</option>
                            <option value="China" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'China' ? 'selected' : '' }}>China</option>
                            <option value="Colombia" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                            <option value="Comoros" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Comoros' ? 'selected' : '' }}>Comoros</option>
                            <option value="Congo, Democratic Republic of the" {{ old('dual_country_dropdown', $profile->dual_country_dropdown ?? '') == 'Congo, Democratic Republic of the' ? 'selected' : '' }}>Congo, Democratic Republic of the</option>
                                <!-- Add all other countries as needed -->
                            </select>
                        </div>
                        <div class="col-md-4" id="dualCountryText" style="display:none;">
                            <label for="dual_country" class="form-label">Other Country:</label>
                        <input type="text" name="dual_country" id="dual_country" class="form-control" placeholder="e.g., USA, Japan" value="{{ old('dual_country', $profile->dual_country ?? '') }}">
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Permanent Address</h5>
                            </div>
                            <div class="col-md-2">
                                <label for="perm_house_unit_no" class="form-label">House/Unit No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_house_unit_no') is-invalid @enderror" id="perm_house_unit_no" name="perm_house_unit_no" value="{{ old('perm_house_unit_no', $profile->perm_house_unit_no ?? '') }}">
                                @error('perm_house_unit_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_street" class="form-label">Street <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_street') is-invalid @enderror" id="perm_street" name="perm_street" value="{{ old('perm_street', $profile->perm_street ?? '') }}">
                                @error('perm_street')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_barangay') is-invalid @enderror" id="perm_barangay" name="perm_barangay" value="{{ old('perm_barangay', $profile->perm_barangay ?? '') }}">
                                @error('perm_barangay')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_city_municipality" class="form-label">City/Municipality <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_city_municipality') is-invalid @enderror" id="perm_city_municipality" name="perm_city_municipality" value="{{ old('perm_city_municipality', $profile->perm_city_municipality ?? '') }}">
                                @error('perm_city_municipality')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_province" class="form-label">Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_province') is-invalid @enderror" id="perm_province" name="perm_province" value="{{ old('perm_province', $profile->perm_province ?? '') }}">
                                @error('perm_province')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_zipcode" class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('perm_zipcode') is-invalid @enderror" id="perm_zipcode" name="perm_zipcode" value="{{ old('perm_zipcode', $profile->perm_zipcode ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('perm_zipcode')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Resident Address </h5>
                            </div>
                            <div class="col-md-2">
                                <label for="res_house_unit_no" class="form-label">House/Unit No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('res_house_unit_no') is-invalid @enderror" id="res_house_unit_no" name="res_house_unit_no" value="{{ old('res_house_unit_no', $profile->res_house_unit_no ?? '') }}">
                                @error('res_house_unit_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_street" class="form-label">Street <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('res_street') is-invalid @enderror" id="res_street" name="res_street" value="{{ old('res_street', $profile->res_street ?? '') }}">
                                @error('res_street')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('res_barangay') is-invalid @enderror" id="res_barangay" name="res_barangay" value="{{ old('res_barangay', $profile->res_barangay ?? '') }}">
                                @error('res_barangay')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_city_municipality" class="form-label">City/Municipality <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('res_city_municipality') is-invalid @enderror" id="res_city_municipality" name="res_city_municipality" value="{{ old('res_city_municipality', $profile->res_city_municipality ?? '') }}">
                                @error('res_city_municipality')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_province" class="form-label">Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('res_province') is-invalid @enderror" id="res_province" name="res_province" value="{{ old('res_province', $profile->res_province ?? '') }}">
                                @error('res_province')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_zipcode" class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" inputmode="decimal" pattern="^\d*\.?\d*$" class="form-control @error('res_zipcode') is-invalid @enderror" id="res_zipcode" name="res_zipcode" value="{{ old('res_zipcode', $profile->res_zipcode ?? '') }}" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('res_zipcode')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary" onclick="saveCurrentSection('section1')">Save Section I</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>









<!-- section 2 -->
        <div class="tab-pane fade" id="section2" role="tabpanel" aria-labelledby="tab-section2">
            <!-- Section 2 content -->
            <div class="container-fluid">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">II. Family Background</h3>
                    </div>
                    <div class="card-body">
                  <!-- Section II fields go here -->
                  <div class="row">
                      <div class="col-12">
                          <h5>Spouse's Information</h5>
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_surname" class="form-label">Spouse's Surname</label>
                        <input type="text" class="form-control @error('spouse_surname') is-invalid @enderror" id="spouse_surname" name="spouse_surname" value="{{ old('spouse_surname', $profile->spouse_surname ?? '') }}">
                          @error('spouse_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('spouse_first_name') is-invalid @enderror" id="spouse_first_name" name="spouse_first_name" value="{{ old('spouse_first_name', $profile->spouse_first_name ?? '') }}">
                          @error('spouse_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('spouse_middle_name') is-invalid @enderror" id="spouse_middle_name" name="spouse_middle_name" value="{{ old('spouse_middle_name', $profile->spouse_middle_name ?? '') }}">
                          @error('spouse_middle_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_name_extension" class="form-label">Name Extension (Jr., Sr.)</label>
                        <input type="text" class="form-control @error('spouse_name_extension') is-invalid @enderror" id="spouse_name_extension" name="spouse_name_extension" value="{{ old('spouse_name_extension', $profile->spouse_name_extension ?? '') }}">
                          @error('spouse_name_extension')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control @error('spouse_occupation') is-invalid @enderror" id="spouse_occupation" name="spouse_occupation" value="{{ old('spouse_occupation', $profile->spouse_occupation ?? '') }}">
                          @error('spouse_occupation')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_employer" class="form-label">Employer/Business Name</label>
                        <input type="text" class="form-control @error('spouse_employer') is-invalid @enderror" id="spouse_employer" name="spouse_employer" value="{{ old('spouse_employer', $profile->spouse_employer ?? '') }}">
                          @error('spouse_employer')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_business_address" class="form-label">Business Address</label>
                        <input type="text" class="form-control @error('spouse_business_address') is-invalid @enderror" id="spouse_business_address" name="spouse_business_address" value="{{ old('spouse_business_address', $profile->spouse_business_address ?? '') }}">
                          @error('spouse_business_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_telephone_no" class="form-label">Telephone No.</label>
                        <input type="text" class="form-control @error('spouse_telephone_no') is-invalid @enderror" id="spouse_telephone_no" name="spouse_telephone_no" value="{{ old('spouse_telephone_no', $profile->spouse_telephone_no ?? '') }}">
                          @error('spouse_telephone_no')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-12">
                          <h5>Father's Information</h5>
                      </div>
                      <div class="col-md-3">
                          <label for="father_surname" class="form-label">Father's Surname</label>
                        <input type="text" class="form-control @error('father_surname') is-invalid @enderror" id="father_surname" name="father_surname" value="{{ old('father_surname', $profile->father_surname ?? '') }}">
                          @error('father_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('father_first_name') is-invalid @enderror" id="father_first_name" name="father_first_name" value="{{ old('father_first_name', $profile->father_first_name ?? '') }}">
                          @error('father_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('father_middle_name') is-invalid @enderror" id="father_middle_name" name="father_middle_name" value="{{ old('father_middle_name', $profile->father_middle_name ?? '') }}">
                          @error('father_middle_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_name_extension" class="form-label">Name Extension (Jr., Sr.)</label>
                        <input type="text" class="form-control @error('father_name_extension') is-invalid @enderror" id="father_name_extension" name="father_name_extension" value="{{ old('father_name_extension', $profile->father_name_extension ?? '') }}">
                          @error('father_name_extension')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-12">
                          <h5>Mother's Maiden Name</h5>
                      </div>
                      <div class="col-md-4">
                          <label for="mother_surname" class="form-label">Surname</label>
                        <input type="text" class="form-control @error('mother_surname') is-invalid @enderror" id="mother_surname" name="mother_surname" value="{{ old('mother_surname', $profile->mother_surname ?? '') }}">
                          @error('mother_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-4">
                          <label for="mother_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('mother_first_name') is-invalid @enderror" id="mother_first_name" name="mother_first_name" value="{{ old('mother_first_name', $profile->mother_first_name ?? '') }}">
                          @error('mother_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-4">
                          <label for="mother_middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('mother_middle_name') is-invalid @enderror" id="mother_middle_name" name="mother_middle_name" value="{{ old('mother_middle_name', $profile->mother_middle_name ?? '') }}">
                          @error('mother_middle_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-12">
                          <h5>Children</h5>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Name of Children (Full Name)</th>
                                      <th>Date of Birth (mm/dd/yyyy)</th>
                                    <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody id="childrenTableBody">
                                @php
                                    $children = old('children', $profile->children ?? []);
                                    if (is_string($children)) $children = json_decode($children, true) ?? [];
                                @endphp
                                @if(!empty($children))
                                    @foreach($children as $child)
                                        <tr>
                                            <td>
                                                <input type="text" name="children_names[]" class="form-control" value="{{ $child['name'] ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="date" name="children_birthdates[]" class="form-control" value="{{ $child['birthdate'] ?? '' }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeChildRow(this)">X</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                  <tr>
                                      <td><input type="text" name="children_names[]" class="form-control"></td>
                                      <td><input type="date" name="children_birthdates[]" class="form-control"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeChildRow(this)">X</button></td>
                                  </tr>
                                @endif
                              </tbody>
                          </table>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addChildRow()">Add Child</button>
                      </div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-12 d-flex justify-content-end">
                          <button type="button" class="btn btn-primary" onclick="saveCurrentSection('section2')">Save Section II</button>
                      </div>
                  </div>
            </div>
                    
                </div>
            </div>
        </div>



        

        <div class="tab-pane fade" id="section3" role="tabpanel" aria-labelledby="tab-section3">
            <div class="container-fluid">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">III. Educational Background</h3>
                    </div>
                    <div class="card-body">
                        <!-- Section III form fields go here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="section4" role="tabpanel" aria-labelledby="tab-section4">
            <div class="container-fluid">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">IV. Civil Service Eligibility</h3>
                    </div>
                    <div class="card-body">
                        <!-- Section IV form fields go here -->
                    </div>
                </div>
            </div>
        </div>


        </div>
    </div>
</form>



<script>
function addChildRow() {
    let row = `<tr>
        <td><input type="text" name="children_names[]" class="form-control"></td>
        <td><input type="date" name="children_birthdates[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeChildRow(this)">X</button></td>
    </tr>`;
    document.getElementById('childrenTableBody').insertAdjacentHTML('beforeend', row);
}

function addEligibilityRow() {
    let count = document.querySelectorAll('.eligibility-row').length + 1;
    let row = `<div class=\"eligibility-row mb-3\">
        <div class=\"row g-2\">
            <div class=\"col-md-4\">
                <label>Career Service/RA 1080/Board/Bar/etc.</label>
                <input type=\"text\" name=\"eligibility_service[]\" class=\"form-control\">
            </div>
            <div class=\"col-md-2\">
                <label>Rating (if applicable)</label>
                <input type=\"text\" name=\"eligibility_rating[]\" class=\"form-control\">
                        </div>
            <div class=\"col-md-2\">
                <label>Date of Exam</label>
                <input type=\"date\" name=\"eligibility_exam_date[]\" class=\"form-control\">
                            </div>
            <div class=\"col-md-4\">
                <label>Place of Exam</label>
                <input type=\"text\" name=\"eligibility_exam_place[]\" class=\"form-control\">
                            </div>
            
                        </div>
        <div class=\"row g-2 mt-2\">
            <div class=\"col-md-4\">
                <label>License (if applicable)</label>
                <input type=\"text\" name=\"eligibility_license[]\" class=\"form-control\">
                    </div>
            <div class=\"col-md-4\">
                <label>License Number</label>
                <input type=\"text\" name=\"eligibility_license_number[]\" class=\"form-control\">
                        </div>
            <div class=\"col-md-3\">
                <label>Date of Validity</label>
                <input type=\"date\" name=\"eligibility_validity[]\" class=\"form-control\">
                            </div>
              <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeEligibilityRow(this)">Remove</button>
                            </div>
                        </div>
        <hr>
    </div>`;
    document.getElementById('eligibilityContainer').insertAdjacentHTML('beforeend', row);
}

function removeEligibilityRow(btn) {
    btn.closest('.eligibility-row').remove();
    // Optionally, renumber the entries after removal
    document.querySelectorAll('.eligibility-row').forEach((row, idx) => {
        let label = row.querySelector('strong');
        if (label) label.textContent = `Entry #${idx + 1}`;
    });
}

function updateWorkExperienceNumbers() {
    const rows = document.querySelectorAll('#work-experience-rows .work-experience-row');
    rows.forEach((row, idx) => {
        row.querySelector('.entry-number').textContent = (idx + 1) + '.';
    });
}

function addWorkExperienceRow() {
    const container = document.getElementById('work-experience-rows');
    const row = document.createElement('div');
    row.className = 'work-experience-row mb-3';
    row.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="col-12 mb-2">
                <strong class="entry-number"></strong>
                        </div>
                        <div class="col-md-4">
                <label>Inclusive Dates<br><small>(mm/dd/yyyy)</small></label>
                <input type="text" name="work_inclusive_dates[]" class="form-control" placeholder="e.g. 01/01/2020 - 12/31/2020">
                        </div>
                        <div class="col-md-4">
                <label>Position Title<br><small>(Write in full/Do not abbreviate)</small></label>
                <input type="text" name="work_position_title[]" class="form-control">
                        </div>
                        <div class="col-md-4">
                <label>Department/Agency/Office/Company<br><small>(Write in full/Do not abbreviate)</small></label>
                <input type="text" name="work_department[]" class="form-control">
                        </div>
                        <div class="col-md-4">
                <label>Monthly Salary</label>
                <input type="text" name="work_monthly_salary[]" class="form-control">
                        </div>
                        <div class="col-md-4">
                <label>Salary/Job/Pay Grade & Step<br><small>(if applicable) & Step Increment</small></label>
                <input type="text" name="work_salary_grade[]" class="form-control">
                        </div>
                        <div class="col-md-4">
                <label>Status of Appointment</label>
                <input type="text" name="work_status[]" class="form-control">
                        </div>
                        <div class="col-md-4">
                <label>Govt Service<br><small>(Y/N)</small></label>
                <div class="d-flex align-items-end">
                    <input type="text" name="work_govt_service[]" class="form-control me-2" maxlength="3" style="max-width: 80%;">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeWorkExperienceRow(this)">Remove</button>
                            </div>
                            </div>
                        </div>
        <hr>
    `;
    container.appendChild(row);
    updateWorkExperienceNumbers();
}

function removeWorkExperienceRow(btn) {
    const row = btn.closest('.work-experience-row');
    if (row) row.remove();
    updateWorkExperienceNumbers();
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelectorAll('#work-experience-rows .work-experience-row').length === 0) {
        addWorkExperienceRow();
    }
});

function addVoluntaryRow() {
    let tableBody = document.getElementById('voluntaryTableBody');
    let rowCount = tableBody.rows.length;
    let row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" name="voluntary[${rowCount}][organization]" class="form-control"></td>
        <td><input type="date" name="voluntary[${rowCount}][from]" class="form-control"></td>
        <td><input type="date" name="voluntary[${rowCount}][to]" class="form-control"></td>
        <td><input type="text" name="voluntary[${rowCount}][hours]" class="form-control"></td>
        <td>
            <div class="d-flex">
                <input type="text" name="voluntary[${rowCount}][position]" class="form-control me-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeVoluntaryRow(this)">Remove</button>
            </div>
        </td>
    `;
    tableBody.appendChild(row);
}

function removeVoluntaryRow(btn) {
    let tableBody = document.getElementById('voluntaryTableBody');
    if (tableBody.rows.length > 1) {
        let row = btn.closest('tr');
        if (row) row.remove();
        reindexVoluntaryRows();
    }
}

function reindexVoluntaryRows() {
    let tableBody = document.getElementById('voluntaryTableBody');
    Array.from(tableBody.rows).forEach((row, idx) => {
        row.querySelectorAll('input').forEach(input => {
            let name = input.getAttribute('name');
            if (name) {
                // Replace the index in the name with the new idx
                input.setAttribute('name', name.replace(/voluntary\\[\\d+\\]/, `voluntary[${idx}]`));
            }
        });
    });
}

function addLDRow() {
    let tableBody = document.getElementById('ldTableBody');
    let rowCount = tableBody.rows.length;
    let row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" name="ld[${rowCount}][title]" class="form-control"></td>
        <td><input type="date" name="ld[${rowCount}][from]" class="form-control"></td>
        <td><input type="date" name="ld[${rowCount}][to]" class="form-control"></td>
        <td><input type="text" name="ld[${rowCount}][hours]" class="form-control"></td>
        <td><input type="text" name="ld[${rowCount}][type]" class="form-control"></td>
        <td><div class="d-flex">
            <input type="text" name="ld[${rowCount}][sponsor]" class="form-control me-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeLDRow(this)">Remove</button>
        </div></td>
    `;
    tableBody.appendChild(row);
}

function removeLDRow(btn) {
    let tableBody = document.getElementById('ldTableBody');
    if (tableBody.rows.length > 1) {
        let row = btn.closest('tr');
        if (row) row.remove();
        reindexLDRows();
    }
}

function reindexLDRows() {
    let tableBody = document.getElementById('ldTableBody');
    Array.from(tableBody.rows).forEach((row, idx) => {
        row.querySelectorAll('input').forEach(input => {
            let name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/ld\[\d+\]/, `ld[${idx}]`));
            }
        });
    });
}



function removeField(btn, containerId) {
    const container = document.getElementById(containerId);
    if (container.children.length > 1) {
        btn.parentElement.remove();
    }
}

function addSkillField() {
    const container = document.getElementById('skillsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="special_skills_hobbies[]" class="form-control" placeholder="Enter your special skills and hobbies">
        <button type="button" class="btn btn-danger" onclick="removeField(this, 'skillsContainer')">Remove</button>`;
    container.appendChild(div);
}

function addDistinctionField() {
    const container = document.getElementById('distinctionsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="non_academic_distinctions[]" class="form-control" placeholder="Enter your non-academic distinctions or recognition">
        <button type="button" class="btn btn-danger" onclick="removeField(this, 'distinctionsContainer')">Remove</button>`;
    container.appendChild(div);
}

function addMembershipField() {
    const container = document.getElementById('membershipContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="association_memberships[]" class="form-control" placeholder="Enter your membership in association/organization">
        <button type="button" class="btn btn-danger" onclick="removeField(this, 'membershipContainer')">Remove</button>`;
    container.appendChild(div);
}

function saveCurrentSection(sectionId) {
    const section = document.getElementById(sectionId);
    const inputs = section.querySelectorAll('[name]');
    const formData = new FormData();
    formData.append('section', sectionId);
    inputs.forEach(input => {
        if ((input.type === 'checkbox' || input.type === 'radio') && !input.checked) return;
        formData.append(input.name, input.value);
    });
    fetch("{{ route('user.profile.saveSection') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Section saved!',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}


</script>

@endsection

