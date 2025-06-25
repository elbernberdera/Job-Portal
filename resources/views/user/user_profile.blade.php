@extends('user.base.base')

@section('main_content')

@push('styles')
<link href="{{ asset('assets/static/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

<div class="content">
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
                        <div class="col-md-4" id="dualCountryDropdown" style="display:none;">
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
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Next Page
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
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">II. Family Background</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                  
                </form>
            </div>
        </div>
    </div>
</div>
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
    var dualCountryDropdown = document.getElementById('dualCountryDropdown');
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
@endpush
