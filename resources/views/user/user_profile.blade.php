@extends('user.base.base')

<script>
function showSection(sectionId) {
    // Hide all sections
    var sections = document.querySelectorAll('.content');
    sections.forEach(function(section) {
        section.style.display = 'none';
    });
    // Show the requested section
    document.getElementById(sectionId).style.display = 'block';
}
</script>

@section('main_content')

@push('styles')
<link href="{{ asset('assets/static/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

<div class="content" id="section1">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">I. Personal Information</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                                <label for="middle_initial">Middle Name</label>
                                <input type="text" class="form-control @error('middle_initial') is-invalid @enderror" 
                                       id="middle_initial" name="middle_initial" 
                                       value="{{ old('middle_initial', $user->middle_initial) }}" 
                                       placeholder="M.I." maxlength="1">
                                @error('middle_initial')
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
                                <select class="form-select select2" id="sex" name="sex" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male" {{ old('sex', $user->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('sex', $user->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('sex', $user->sex) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('sex')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                                <select class="form-select custom-chevron" id="civil_status" name="civil_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Single" {{ old('civil_status', $user->civil_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status', $user->civil_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ old('civil_status', $user->civil_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Separated" {{ old('civil_status', $user->civil_status ?? '') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                    <option value="Divorced" {{ old('civil_status', $user->civil_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                                @error('civil_status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="height" class="form-label">Height (m)</label>
                            <input type="text" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $user->height ?? '') }}">
                            @error('height')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $user->weight ?? '') }}">
                            @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="blood_type" class="form-label">Blood Type</label>
                            <input type="text" class="form-control @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" value="{{ old('blood_type', $user->blood_type ?? '') }}">
                            @error('blood_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="gsis_id_no" class="form-label">GSIS ID No.</label>
                            <input type="text" class="form-control @error('gsis_id_no') is-invalid @enderror" id="gsis_id_no" name="gsis_id_no" value="{{ old('gsis_id_no', $user->gsis_id_no ?? '') }}">
                            @error('gsis_id_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="pagibig_id_no" class="form-label">PAG-IBIG ID No.</label>
                            <input type="text" class="form-control @error('pagibig_id_no') is-invalid @enderror" id="pagibig_id_no" name="pagibig_id_no" value="{{ old('pagibig_id_no', $user->pagibig_id_no ?? '') }}">
                            @error('pagibig_id_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="philhealth_no" class="form-label">PhilHealth No.</label>
                            <input type="text" class="form-control @error('philhealth_no') is-invalid @enderror" id="philhealth_no" name="philhealth_no" value="{{ old('philhealth_no', $user->philhealth_no ?? '') }}">
                            @error('philhealth_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="sss_no" class="form-label">SSS No.</label>
                            <input type="text" class="form-control @error('sss_no') is-invalid @enderror" id="sss_no" name="sss_no" value="{{ old('sss_no', $user->sss_no ?? '') }}">
                            @error('sss_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tin_no" class="form-label">TIN No.</label>
                            <input type="text" class="form-control @error('tin_no') is-invalid @enderror" id="tin_no" name="tin_no" value="{{ old('tin_no', $user->tin_no ?? '') }}">
                            @error('tin_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="agency_employee_no" class="form-label">Agency Employee No.</label>
                            <input type="text" class="form-control @error('agency_employee_no') is-invalid @enderror" id="agency_employee_no" name="agency_employee_no" value="{{ old('agency_employee_no', $user->agency_employee_no ?? '') }}">
                            @error('agency_employee_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="citizenship" class="form-label">Citizenship</label>
                            <select id="citizenship" name="citizenship" class="form-select" onchange="toggleDualDetails()">
                                <option value="">-- Select Citizenship --</option>
                                <option value="Filipino" {{ old('citizenship', $user->citizenship ?? '') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                <option value="Dual Citizenship by Birth" {{ old('citizenship', $user->citizenship ?? '') == 'Dual Citizenship by Birth' ? 'selected' : '' }}>Dual Citizenship (By Birth)</option>
                                <option value="Dual Citizenship by Naturalization" {{ old('citizenship', $user->citizenship ?? '') == 'Dual Citizenship by Naturalization' ? 'selected' : '' }}>Dual Citizenship (By Naturalization)</option>
                                <option value="Others" {{ old('citizenship', $user->citizenship ?? '') == 'Others' ? 'selected' : '' }}>Others (Specify Country)</option>
                            </select>
                            @error('citizenship')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4" id="dualcitizinshipDropdown" >
                            <label for="dual_country_dropdown" class="form-label">Select Country:</label>
                            <select name="dual_country_dropdown" id="dual_country_dropdown" class="form-select">
                                <option value="">-- Select Country --</option>
                                <option value="Algeria">Algeria</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas, The">Bahamas, The</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burma">Burma</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                                <!-- Add all other countries as needed -->
                            </select>
                        </div>
                        <div class="col-md-4" id="dualCountryText" style="display:none;">
                            <label for="dual_country" class="form-label">Other Country:</label>
                            <input type="text" name="dual_country" id="dual_country" class="form-control" placeholder="e.g., USA, Japan" value="{{ old('dual_country', $user->dual_country ?? '') }}">
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Permanent Address</h5>
                            </div>
                            <div class="col-md-2">
                                <label for="perm_house_unit_no" class="form-label">House/Unit No.</label>
                                <input type="text" class="form-control @error('perm_house_unit_no') is-invalid @enderror" id="perm_house_unit_no" name="perm_house_unit_no" value="{{ old('perm_house_unit_no', $user->perm_house_unit_no ?? '') }}">
                                @error('perm_house_unit_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_street" class="form-label">Street</label>
                                <input type="text" class="form-control @error('perm_street') is-invalid @enderror" id="perm_street" name="perm_street" value="{{ old('perm_street', $user->perm_street ?? '') }}">
                                @error('perm_street')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_barangay" class="form-label">Barangay</label>
                                <input type="text" class="form-control @error('perm_barangay') is-invalid @enderror" id="perm_barangay" name="perm_barangay" value="{{ old('perm_barangay', $user->perm_barangay ?? '') }}">
                                @error('perm_barangay')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_city_municipality" class="form-label">City/Municipality</label>
                                <input type="text" class="form-control @error('perm_city_municipality') is-invalid @enderror" id="perm_city_municipality" name="perm_city_municipality" value="{{ old('perm_city_municipality', $user->perm_city_municipality ?? '') }}">
                                @error('perm_city_municipality')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_province" class="form-label">Province</label>
                                <input type="text" class="form-control @error('perm_province') is-invalid @enderror" id="perm_province" name="perm_province" value="{{ old('perm_province', $user->perm_province ?? '') }}">
                                @error('perm_province')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="perm_zipcode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('perm_zipcode') is-invalid @enderror" id="perm_zipcode" name="perm_zipcode" value="{{ old('perm_zipcode', $user->perm_zipcode ?? '') }}">
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
                                <label for="res_house_unit_no" class="form-label">House/Unit No.</label>
                                <input type="text" class="form-control @error('res_house_unit_no') is-invalid @enderror" id="res_house_unit_no" name="res_house_unit_no" value="{{ old('res_house_unit_no', $user->res_house_unit_no ?? '') }}">
                                @error('res_house_unit_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_street" class="form-label">Street</label>
                                <input type="text" class="form-control @error('res_street') is-invalid @enderror" id="res_street" name="res_street" value="{{ old('res_street', $user->res_street ?? '') }}">
                                @error('res_street')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_barangay" class="form-label">Barangay</label>
                                <input type="text" class="form-control @error('res_barangay') is-invalid @enderror" id="res_barangay" name="res_barangay" value="{{ old('res_barangay', $user->res_barangay ?? '') }}">
                                @error('res_barangay')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_city_municipality" class="form-label">City/Municipality</label>
                                <input type="text" class="form-control @error('res_city_municipality') is-invalid @enderror" id="res_city_municipality" name="res_city_municipality" value="{{ old('res_city_municipality', $user->res_city_municipality ?? '') }}">
                                @error('res_city_municipality')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_province" class="form-label">Province</label>
                                <input type="text" class="form-control @error('res_province') is-invalid @enderror" id="res_province" name="res_province" value="{{ old('res_province', $user->res_province ?? '') }}">
                                @error('res_province')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="res_zipcode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('res_zipcode') is-invalid @enderror" id="res_zipcode" name="res_zipcode" value="{{ old('res_zipcode', $user->res_zipcode ?? '') }}">
                                @error('res_zipcode')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-primary" onclick="showSection('section2')">
                                <i class="fas fa-arrow-right"></i> Next Page
                            </button>
                            <!-- <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section II -->
<div class="content" id="section2" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">II. Family Background</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                  <!-- Section II fields go here -->
                  <div class="row">
                      <div class="col-12">
                          <h5>Spouse's Information</h5>
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_surname" class="form-label">Spouse's Surname</label>
                          <input type="text" class="form-control @error('spouse_surname') is-invalid @enderror" id="spouse_surname" name="spouse_surname" value="{{ old('spouse_surname', $user->spouse_surname ?? '') }}">
                          @error('spouse_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_first_name" class="form-label">First Name</label>
                          <input type="text" class="form-control @error('spouse_first_name') is-invalid @enderror" id="spouse_first_name" name="spouse_first_name" value="{{ old('spouse_first_name', $user->spouse_first_name ?? '') }}">
                          @error('spouse_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_middle_name" class="form-label">Middle Name</label>
                          <input type="text" class="form-control @error('spouse_middle_name') is-invalid @enderror" id="spouse_middle_name" name="spouse_middle_name" value="{{ old('spouse_middle_name', $user->spouse_middle_name ?? '') }}">
                          @error('spouse_middle_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_name_extension" class="form-label">Name Extension (Jr., Sr.)</label>
                          <input type="text" class="form-control @error('spouse_name_extension') is-invalid @enderror" id="spouse_name_extension" name="spouse_name_extension" value="{{ old('spouse_name_extension', $user->spouse_name_extension ?? '') }}">
                          @error('spouse_name_extension')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_occupation" class="form-label">Occupation</label>
                          <input type="text" class="form-control @error('spouse_occupation') is-invalid @enderror" id="spouse_occupation" name="spouse_occupation" value="{{ old('spouse_occupation', $user->spouse_occupation ?? '') }}">
                          @error('spouse_occupation')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_employer" class="form-label">Employer/Business Name</label>
                          <input type="text" class="form-control @error('spouse_employer') is-invalid @enderror" id="spouse_employer" name="spouse_employer" value="{{ old('spouse_employer', $user->spouse_employer ?? '') }}">
                          @error('spouse_employer')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_business_address" class="form-label">Business Address</label>
                          <input type="text" class="form-control @error('spouse_business_address') is-invalid @enderror" id="spouse_business_address" name="spouse_business_address" value="{{ old('spouse_business_address', $user->spouse_business_address ?? '') }}">
                          @error('spouse_business_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="spouse_telephone_no" class="form-label">Telephone No.</label>
                          <input type="text" class="form-control @error('spouse_telephone_no') is-invalid @enderror" id="spouse_telephone_no" name="spouse_telephone_no" value="{{ old('spouse_telephone_no', $user->spouse_telephone_no ?? '') }}">
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
                          <input type="text" class="form-control @error('father_surname') is-invalid @enderror" id="father_surname" name="father_surname" value="{{ old('father_surname', $user->father_surname ?? '') }}">
                          @error('father_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_first_name" class="form-label">First Name</label>
                          <input type="text" class="form-control @error('father_first_name') is-invalid @enderror" id="father_first_name" name="father_first_name" value="{{ old('father_first_name', $user->father_first_name ?? '') }}">
                          @error('father_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_middle_name" class="form-label">Middle Name</label>
                          <input type="text" class="form-control @error('father_middle_name') is-invalid @enderror" id="father_middle_name" name="father_middle_name" value="{{ old('father_middle_name', $user->father_middle_name ?? '') }}">
                          @error('father_middle_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-3">
                          <label for="father_name_extension" class="form-label">Name Extension (Jr., Sr.)</label>
                          <input type="text" class="form-control @error('father_name_extension') is-invalid @enderror" id="father_name_extension" name="father_name_extension" value="{{ old('father_name_extension', $user->father_name_extension ?? '') }}">
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
                          <input type="text" class="form-control @error('mother_surname') is-invalid @enderror" id="mother_surname" name="mother_surname" value="{{ old('mother_surname', $user->mother_surname ?? '') }}">
                          @error('mother_surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-4">
                          <label for="mother_first_name" class="form-label">First Name</label>
                          <input type="text" class="form-control @error('mother_first_name') is-invalid @enderror" id="mother_first_name" name="mother_first_name" value="{{ old('mother_first_name', $user->mother_first_name ?? '') }}">
                          @error('mother_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                      </div>
                      <div class="col-md-4">
                          <label for="mother_middle_name" class="form-label">Middle Name</label>
                          <input type="text" class="form-control @error('mother_middle_name') is-invalid @enderror" id="mother_middle_name" name="mother_middle_name" value="{{ old('mother_middle_name', $user->mother_middle_name ?? '') }}">
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
                                  </tr>
                              </thead>
                              <tbody id="childrenTableBody">
                                  <tr>
                                      <td><input type="text" name="children_names[]" class="form-control"></td>
                                      <td><input type="date" name="children_birthdates[]" class="form-control"></td>
                                  </tr>
                              </tbody>
                          </table>
                          <button type="button" class="btn btn-sm btn-success" onclick="addChildRow()">Add Child</button>
                      </div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-12 d-flex justify-content-end">
                          <button type="button" class="btn btn-secondary me-2" onclick="showSection('section1')">
                              <i class="fas fa-arrow-left"></i> Back
                          </button>
                          <button type="button" class="btn btn-primary" onclick="showSection('section3')">
                              Next Page <i class="fas fa-arrow-right"></i>
                          </button>
                      </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section III -->
<div class="content" id="section3" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">III. Educational Background</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">

                <h6>ELEMENTARY</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="elementary_school_name" class="form-label">Name of School</label>
                        <input type="text" id="elementary_school_name" name="elementary_school_name" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="elementary_degree" class="form-label">Degree or Course</label>
                        <input type="text" id="elementary_degree" name="elementary_degree" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="elementary_from" class="form-label">From</label>
                        <input type="date" id="elementary_from" name="elementary_from" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="elementary_to" class="form-label">To</label>
                        <input type="date" id="elementary_to" name="elementary_to" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="elementary_highest_level" class="form-label">Highest Level/Units Earned (if not graduated)</label>
                        <input type="text" id="elementary_highest_level" name="elementary_highest_level" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="elementary_year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" id="elementary_year_graduated" name="elementary_year_graduated" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="elementary_honors" class="form-label">Scholarship/Academic Honors Received</label>
                        <input type="text" id="elementary_honors" name="elementary_honors" class="form-control" placeholder="">
                    </div>
                </div>
                <hr>

                <h6>SECONDARY</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="secondary_school_name" class="form-label">Name of School</label>
                        <input type="text" id="secondary_school_name" name="secondary_school_name" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="secondary_degree" class="form-label">Degree or Course</label>
                        <input type="text" id="secondary_degree" name="secondary_degree" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="secondary_from" class="form-label">From</label>
                        <input type="date" id="secondary_from" name="secondary_from" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="secondary_to" class="form-label">To</label>
                        <input type="date" id="secondary_to" name="secondary_to" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="secondary_highest_level" class="form-label">Highest Level/Units Earned (if not graduated)</label>
                        <input type="text" id="secondary_highest_level" name="secondary_highest_level" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="secondary_year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" id="secondary_year_graduated" name="secondary_year_graduated" class="form-control" placeholder=" ">
                    </div>
                    <div class="col-md-4">
                        <label for="secondary_honors" class="form-label">Scholarship/Academic Honors Received</label>
                        <input type="text" id="secondary_honors" name="secondary_honors" class="form-control" placeholder="">
                    </div>
                </div>
                <hr>

                <h6>VOCATIONAL / TRADE COURSE</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="vocational_school_name" class="form-label">Name of School</label>
                        <input type="text" id="vocational_school_name" name="vocational_school_name" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="vocational_degree" class="form-label">Degree or Course</label>
                        <input type="text" id="vocational_degree" name="vocational_degree" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="vocational_from" class="form-label">From</label>
                        <input type="date" id="vocational_from" name="vocational_from" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="vocational_to" class="form-label">To</label>
                        <input type="date" id="vocational_to" name="vocational_to" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="vocational_highest_level" class="form-label">Highest Level/Units Earned (if not graduated)</label>
                        <input type="text" id="vocational_highest_level" name="vocational_highest_level" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="vocational_year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" id="vocational_year_graduated" name="vocational_year_graduated" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="vocational_honors" class="form-label">Scholarship/Academic Honors Received</label>
                        <input type="text" id="vocational_honors" name="vocational_honors" class="form-control" placeholder="">
                    </div>
                </div>
                <hr>

                <h6>COLLEGE</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="college_school_name" class="form-label">Name of School</label>
                        <input type="text" id="college_school_name" name="college_school_name" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="college_degree" class="form-label">Degree or Course</label>
                        <input type="text" id="college_degree" name="college_degree" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="college_from" class="form-label">From</label>
                        <input type="date" id="college_from" name="college_from" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="college_to" class="form-label">To</label>
                        <input type="date" id="college_to" name="college_to" class="form-control" placeholder="o">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="college_highest_level" class="form-label">Highest Level/Units Earned (if not graduated)</label>
                        <input type="text" id="college_highest_level" name="college_highest_level" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="college_year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" id="college_year_graduated" name="college_year_graduated" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="college_honors" class="form-label">Scholarship/Academic Honors Received</label>
                        <input type="text" id="college_honors" name="college_honors" class="form-control" placeholder="">
                    </div>
                </div>
                <hr>

                <h6>GRADUATE STUDIES</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="graduate_school_name" class="form-label">Name of School</label>
                        <input type="text" id="graduate_school_name" name="graduate_school_name" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="graduate_degree" class="form-label">Degree or Course</label>
                        <input type="text" id="graduate_degree" name="graduate_degree" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="graduate_from" class="form-label">From</label>
                        <input type="date" id="graduate_from" name="graduate_from" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="graduate_to" class="form-label">To</label>
                        <input type="date" id="graduate_to" name="graduate_to" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="graduate_highest_level" class="form-label">Highest Level/Units Earned (if not graduated)</label>
                        <input type="text" id="graduate_highest_level" name="graduate_highest_level" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="graduate_year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" id="graduate_year_graduated" name="graduate_year_graduated" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-4">
                        <label for="graduate_honors" class="form-label">Scholarship/Academic Honors Received</label>
                        <input type="text" id="graduate_honors" name="graduate_honors" class="form-control" placeholder="">
                    </div>
                </div>
                <hr>

                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section2')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section4')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Section IV -->
<div class="content" id="section4" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">IV. Civil Service Eligibility</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Career Service/RA 1080 (Board/Bar) Under Special Laws/CES/CSEE Barangay Eligibility/Driver's License</th>
                                <th>Rating<br><small>(If Applicable)</small></th>
                                <th>Date of Examination/Conferment</th>
                                <th>Place of Examination/Conferment</th>
                                <th colspan="2">License (if applicable)</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Number</th>
                                <th>Date of Validity</th>
                            </tr>
                        </thead>
                        <tbody id="eligibilityTableBody">
                            @for($i = 0; $i < 4; $i++)
                            <tr>
                                <td><input type="text" name="eligibility[{{$i}}][type]" class="form-control"></td>
                                <td><input type="text" name="eligibility[{{$i}}][rating]" class="form-control"></td>
                                <td><input type="date" name="eligibility[{{$i}}][exam_date]" class="form-control"></td>
                                <td><input type="text" name="eligibility[{{$i}}][exam_place]" class="form-control"></td>
                                <td><input type="text" name="eligibility[{{$i}}][license_number]" class="form-control"></td>
                                <td><input type="date" name="eligibility[{{$i}}][license_validity]" class="form-control"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addEligibilityRow()">Add Row</button>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section3')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section5')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section V -->
<div class="content" id="section5" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">V. Work Experience</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">Inclusive Dates<br><small>(mm/dd/yyyy)</small></th>
                                <th>Position Title<br><small>(Write in full/Do not abbreviate)</small></th>
                                <th>Department/Agency/Office/Company<br><small>(Write in full/Do not abbreviate)</small></th>
                                <th>Monthly Salary</th>
                                <th>Salary/Job/Pay Grade & Step (if applicable) & Step Increment</th>
                                <th>Status of Appointment</th>
                                <th>Govt Service (Y/N)</th>
                            </tr>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="workTableBody">
                            @for($i = 0; $i < 4; $i++)
                            <tr>
                                <td><input type="date" name="work[{{$i}}][from]" class="form-control"></td>
                                <td><input type="date" name="work[{{$i}}][to]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][position]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][department]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][salary]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][pay_grade]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][appointment_status]" class="form-control"></td>
                                <td><input type="text" name="work[{{$i}}][govt_service]" class="form-control"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addWorkRow()">Add Row</button>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section4')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section6')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section VI -->
<div class="content" id="section6" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">VI. Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organizations</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name & Address of Organization<br><small>(Write in full)</small></th>
                                <th colspan="2">Inclusive Dates<br><small>(mm/dd/yyyy)</small></th>
                                <th>Number of Hours</th>
                                <th>Position / Nature of Work</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>From</th>
                                <th>To</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="voluntaryTableBody">
                            @for($i = 0; $i < 4; $i++)
                            <tr>
                                <td><input type="text" name="voluntary[{{$i}}][organization]" class="form-control"></td>
                                <td><input type="date" name="voluntary[{{$i}}][from]" class="form-control"></td>
                                <td><input type="date" name="voluntary[{{$i}}][to]" class="form-control"></td>
                                <td><input type="text" name="voluntary[{{$i}}][hours]" class="form-control"></td>
                                <td><input type="text" name="voluntary[{{$i}}][position]" class="form-control"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addVoluntaryRow()">Add Row</button>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section5')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section7')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section VII -->
<div class="content" id="section7" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">VII. Learning and Development (L&D) Interventions/Training Programs Attended</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title of Learning and Development Interventions/Training Programs<br><small>(Write in full)</small></th>
                                <th colspan="2">Inclusive Dates of Attendance<br><small>(mm/dd/yyyy)</small></th>
                                <th>Number of Hours</th>
                                <th>Type of LD<br><small>(Managerial/Supervisory/Technical/etc)</small></th>
                                <th>Conducted/Sponsored By<br><small>(Write in full)</small></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>From</th>
                                <th>To</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="ldTableBody">
                            @for($i = 0; $i < 4; $i++)
                            <tr>
                                <td><input type="text" name="ld[{{$i}}][title]" class="form-control"></td>
                                <td><input type="date" name="ld[{{$i}}][from]" class="form-control"></td>
                                <td><input type="date" name="ld[{{$i}}][to]" class="form-control"></td>
                                <td><input type="text" name="ld[{{$i}}][hours]" class="form-control"></td>
                                <td><input type="text" name="ld[{{$i}}][type]" class="form-control"></td>
                                <td><input type="text" name="ld[{{$i}}][sponsor]" class="form-control"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addLDRow()">Add Row</button>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section6')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section8')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Section VIII: OTHER INFORMATION -->
<div class="content" id="section8" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">VIII. OTHER INFORMATION</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <h6>31. SPECIAL SKILLS and HOBBIES</h6>
                    <div id="skillsContainer">
                        <input type="text" name="special_skills_hobbies[]" class="form-control w-100 mb-2" placeholder="Enter your special skills and hobbies">
                    </div>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addSkillField()">Add</button>
                   
                    <h6>32. NON-ACADEMIC DISTINCTIONS / RECOGNITION</h6>
                    <p>(Write in full)</p>
                    <div id="distinctionsContainer">
                        <input type="text" name="non_academic_distinctions[]" class="form-control w-100 mb-2" placeholder="Enter your non-academic distinctions or recognition">
                    </div>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addDistinctionField()">Add</button>

                    <h6>33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION</h6>
                    <p>(Write in full)</p>
                    <div id="membershipContainer">
                        <input type="text" name="association_memberships[]" class="form-control w-100 mb-2" placeholder="Enter your membership in association/organization">
                    </div>
                    <button type="button" class="btn btn-sm btn-success mb-3" onclick="addMembershipField()">Add</button>

                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section7')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection('section9')">
                                Next Page <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- section IX -->
<div class="content" id="section9" style="display:none;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">IX. Information </h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <!-- Question 34a -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                34a. Are you related by consanguinity or affinity to the appointing or recommending authority, or to chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed, within the third degree?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q34a" id="q34a_yes" value="yes">
                                <label class="form-check-label" for="q34a_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q34a" id="q34a_no" value="no">
                                <label class="form-check-label" for="q34a_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q34a_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 34b -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                34b. ...within the fourth degree (for Local Government Unit - Career Employees)?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q34b" id="q34b_yes" value="yes">
                                <label class="form-check-label" for="q34b_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q34b" id="q34b_no" value="no">
                                <label class="form-check-label" for="q34b_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q34b_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 35a -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                35a. Have you ever been found guilty of any administrative offense?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q35a" id="q35a_yes" value="yes">
                                <label class="form-check-label" for="q35a_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q35a" id="q35a_no" value="no">
                                <label class="form-check-label" for="q35a_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q35a_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 35b -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                35b. Have you been criminally charged before any court?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q35b" id="q35b_yes" value="yes">
                                <label class="form-check-label" for="q35b_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q35b" id="q35b_no" value="no">
                                <label class="form-check-label" for="q35b_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q35b_details" placeholder="If YES, give details">
                            <input type="text" class="form-control mt-2" name="q35b_date_filed" placeholder="Date Filed">
                            <input type="text" class="form-control mt-2" name="q35b_status" placeholder="Status of Case/s">
                        </div>
                    </div>
                    <!-- Question 36 -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q36" id="q36_yes" value="yes">
                                <label class="form-check-label" for="q36_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q36" id="q36_no" value="no">
                                <label class="form-check-label" for="q36_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q36_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 37 -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q37" id="q37_yes" value="yes">
                                <label class="form-check-label" for="q37_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q37" id="q37_no" value="no">
                                <label class="form-check-label" for="q37_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q37_details" placeholder="If YES, give details">
                        </div>
                    </div>

                    <!-- Question 38a -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                38a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q38a" id="q38a_yes" value="yes">
                                <label class="form-check-label" for="q38a_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q38a" id="q38a_no" value="no">
                                <label class="form-check-label" for="q38a_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q38a_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 38b -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                38b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q38b" id="q38b_yes" value="yes">
                                <label class="form-check-label" for="q38b_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q38b" id="q38b_no" value="no">
                                <label class="form-check-label" for="q38b_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q38b_details" placeholder="If YES, give details">
                        </div>
                    </div>
                    <!-- Question 39 -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>
                                39. Have you acquired the status of an immigrant or permanent resident of another country?
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q39" id="q39_yes" value="yes">
                                <label class="form-check-label" for="q39_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q39" id="q39_no" value="no">
                                <label class="form-check-label" for="q39_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q39_details" placeholder="If YES, give details (country)">
                        </div>
                    </div>
                    <!-- Question 40 -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>
                                40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following:
                            </label>
                        </div>
                    </div>
                    <!-- 40a -->
                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-1">
                            <label>
                                a. Are you a member of any indigenous group?
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40a" id="q40a_yes" value="yes">
                                <label class="form-check-label" for="q40a_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40a" id="q40a_no" value="no">
                                <label class="form-check-label" for="q40a_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q40a_details" placeholder="If YES, please specify">
                        </div>
                    </div>
                    <!-- 40b -->
                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-1">
                            <label>
                                b. Are you a person with disability?
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40b" id="q40b_yes" value="yes">
                                <label class="form-check-label" for="q40b_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40b" id="q40b_no" value="no">
                                <label class="form-check-label" for="q40b_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q40b_id" placeholder="If YES, please specify ID No.">
                        </div>
                    </div>
                    <!-- 40c -->
                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-1">
                            <label>
                                c. Are you a solo parent?
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40c" id="q40c_yes" value="yes">
                                <label class="form-check-label" for="q40c_yes">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q40c" id="q40c_no" value="no">
                                <label class="form-check-label" for="q40c_no">NO</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="q40c_id" placeholder="If YES, please specify ID No.">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="showSection('section8')">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function addWorkRow() {
    var tableBody = document.getElementById('workTableBody');
    var row = document.createElement('tr');
    row.innerHTML = '<td><input type="date" name="work[][from]" class="form-control"></td>' +
                    '<td><input type="date" name="work[][to]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][position]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][department]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][salary]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][pay_grade]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][appointment_status]" class="form-control"></td>' +
                    '<td><input type="text" name="work[][govt_service]" class="form-control"></td>';
    tableBody.appendChild(row);
}
</script>

@endsection

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


@push('scripts')
<script src="{{ asset('assets/static/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });

    $(document).ready(function() {
    $('#sex').select2({
        placeholder: "Select Sex",
        allowClear: true
    });
});

</script>

<script>
function toggleDualDetails() {
    var citizenship = document.getElementById('citizenship').value;
    var dualCountryDropdown = document.getElementById('dualcitizinshipDropdown');
    var dualCountryText = document.getElementById('dualCountryText');

    if (citizenship === 'Dual Citizenship by Birth' || citizenship === 'Dual Citizenship by Naturalization') {
        dualCountryDropdown.style.display = 'block';
        dualCountryText.style.display = 'none';
    } else if (citizenship === 'Others') {
        dualCountryDropdown.style.display = 'none';
        dualCountryText.style.display = 'block';
    } else {
        dualCountryDropdown.style.display = 'none';
        dualCountryText.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    toggleDualDetails();
});
</script>

<script>
function addChildRow() {
    var tableBody = document.getElementById('childrenTableBody');
    var row = document.createElement('tr');
    row.innerHTML = '<td><input type="text" name="children_names[]" class="form-control"></td>' +
                    '<td><input type="date" name="children_birthdates[]" class="form-control"></td>';
    tableBody.appendChild(row);
}
</script>

<script>
function addEligibilityRow() {
    var tableBody = document.getElementById('eligibilityTableBody');
    var row = document.createElement('tr');
    row.innerHTML = '<td><input type="text" name="eligibility[][type]" class="form-control"></td>' +
                    '<td><input type="text" name="eligibility[][rating]" class="form-control"></td>' +
                    '<td><input type="date" name="eligibility[][exam_date]" class="form-control"></td>' +
                    '<td><input type="text" name="eligibility[][exam_place]" class="form-control"></td>' +
                    '<td><input type="text" name="eligibility[][license_number]" class="form-control"></td>' +
                    '<td><input type="date" name="eligibility[][license_validity]" class="form-control"></td>';
    tableBody.appendChild(row);
}
</script>

<script>
function addVoluntaryRow() {
    var tableBody = document.getElementById('voluntaryTableBody');
    var row = document.createElement('tr');
    row.innerHTML = '<td><input type="text" name="voluntary[][organization]" class="form-control"></td>' +
                    '<td><input type="date" name="voluntary[][from]" class="form-control"></td>' +
                    '<td><input type="date" name="voluntary[][to]" class="form-control"></td>' +
                    '<td><input type="text" name="voluntary[{{$i}}][hours]" class="form-control"></td>' +
                    '<td><input type="text" name="voluntary[{{$i}}][position]" class="form-control"></td>';
    tableBody.appendChild(row);
}
</script>
<script>
function addLDRow() {
    var tableBody = document.getElementById('ldTableBody');
    var row = document.createElement('tr');
    row.innerHTML = '<td><input type="text" name="ld[][title]" class="form-control"></td>' +
                    '<td><input type="date" name="ld[][from]" class="form-control"></td>' +
                    '<td><input type="date" name="ld[][to]" class="form-control"></td>' +
                    '<td><input type="text" name="ld[{{$i}}][hours]" class="form-control"></td>' +
                    '<td><input type="text" name="ld[{{$i}}][type]" class="form-control"></td>' +
                    '<td><input type="text" name="ld[{{$i}}][sponsor]" class="form-control"></td>';
    tableBody.appendChild(row);
}


function addSkillField() {
    var container = document.getElementById('skillsContainer');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'special_skills_hobbies[]';
    input.className = 'form-control w-100 mb-2';
    input.placeholder = 'Enter your special skills and hobbies';
    container.appendChild(input);
}
function addDistinctionField() {
    var container = document.getElementById('distinctionsContainer');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'non_academic_distinctions[]';
    input.className = 'form-control w-100 mb-2';
    input.placeholder = 'Enter your non-academic distinctions or recognition';
    container.appendChild(input);
}
function addMembershipField() {
    var container = document.getElementById('membershipContainer');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'association_memberships[]';
    input.className = 'form-control w-100 mb-2';
    input.placeholder = 'Enter your membership in association/organization';
    container.appendChild(input);
}
</script>

