@extends('user.base.base')

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('static/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('main_content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title w-100 text-center">I. Personal Information</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="last_name">Surname <span style="color: red;">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required>
                            @error('last_name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="first_name">First Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                            @error('first_name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="middle_name">Middle Name <span style="color: #6c757d;">(Optional)</span></label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', auth()->user()->middle_name) }}">
                            @error('middle_name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="name_extension">Suffix <span style="color: #6c757d;">(Optional)</span></label>
                            <select class="form-control @error('name_extension') is-invalid @enderror" id="name_extension" name="name_extension">
                                <option value="">Select...</option>
                                <option value="Jr." {{ old('name_extension', auth()->user()->name_extension) == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ old('name_extension', auth()->user()->name_extension) == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="I" {{ old('name_extension', auth()->user()->name_extension) == 'I' ? 'selected' : '' }}>I</option>
                                <option value="II" {{ old('name_extension', auth()->user()->name_extension) == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ old('name_extension', auth()->user()->name_extension) == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ old('name_extension', auth()->user()->name_extension) == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V" {{ old('name_extension', auth()->user()->name_extension) == 'V' ? 'selected' : '' }}>V</option>
                            </select>
                            @error('name_extension')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of Birth <span style="color: red;">*</span></label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" required>
                            @error('date_of_birth')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="place_of_birth">Place of Birth <span style="color: red;">*</span></label>
                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', auth()->user()->place_of_birth) }}" required>
                            @error('place_of_birth')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="sex">Sex <span style="color: red;">*</span></label>
                            <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                                <option value="" selected disabled>Select...</option>
                                <option value="Male" {{ old('sex', auth()->user()->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex', auth()->user()->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('sex')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="civil_status">Civil Status <span style="color: red;">*</span></label>
                            <select class="form-control @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status" required>
                                <option value="" selected disabled>Select...</option>
                                <option value="Single" {{ old('civil_status', auth()->user()->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status', auth()->user()->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status', auth()->user()->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status', auth()->user()->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="other/s" {{ old('civil_status', auth()->user()->civil_status) == 'others' ? 'selected' : '' }}>others</option>
                            </select>
                            @error('civil_status')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                   
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="height">Height (m)</label>
                            <input type="text" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', optional(auth()->user())->height) }}">
                            @error('height')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="weight">Weight (kg)</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', optional(auth()->user())->weight) }}">
                            @error('weight')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="blood_type">Blood Type</label>
                            <select class="form-control @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
                                <option value="" selected>Select...</option>
                                <option value="A+" {{ old('blood_type', optional(auth()->user())->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_type', optional(auth()->user())->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_type', optional(auth()->user())->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_type', optional(auth()->user())->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_type', optional(auth()->user())->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_type', optional(auth()->user())->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_type', optional(auth()->user())->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_type', optional(auth()->user())->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_type')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="gsis_id_no">GSIS ID NO.</label>
                            <input type="text" class="form-control @error('gsis_id_no') is-invalid @enderror" id="gsis_id_no" name="gsis_id_no" value="{{ old('gsis_id_no', optional(auth()->user())->gsis_id_no) }}">
                             @error('gsis_id_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pagibig_id_no">PAG-IBIG ID NO.</label>
                            <input type="text" class="form-control @error('pagibig_id_no') is-invalid @enderror" id="pagibig_id_no" name="pagibig_id_no" value="{{ old('pagibig_id_no', optional(auth()->user())->pagibig_id_no) }}">
                             @error('pagibig_id_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="philhealth_no">PHILHEALTH NO.</label>
                            <input type="text" class="form-control @error('philhealth_no') is-invalid @enderror" id="philhealth_no" name="philhealth_no" value="{{ old('philhealth_no', optional(auth()->user())->philhealth_no) }}">
                             @error('philhealth_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="sss_no">SSS NO.</label>
                            <input type="text" class="form-control @error('sss_no') is-invalid @enderror" id="sss_no" name="sss_no" value="{{ old('sss_no', optional(auth()->user())->sss_no) }}">
                             @error('sss_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tin_no">TIN NO.</label>
                            <input type="text" class="form-control @error('tin_no') is-invalid @enderror" id="tin_no" name="tin_no" value="{{ old('tin_no', optional(auth()->user())->tin_no) }}">
                             @error('tin_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="agency_employee_no">Agency Employee No.</label>
                            <input type="text" class="form-control @error('agency_employee_no') is-invalid @enderror" id="agency_employee_no" name="agency_employee_no" value="{{ old('agency_employee_no', optional(auth()->user())->agency_employee_no) }}">
                            @error('agency_employee_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    <!-- Residential Address -->
                    <div class="row border-top mt-3 py-2">
                        <div class="col-md-3" style="background-color: #e9ecef; display: flex; flex-direction: column; justify-content: space-between; padding: 15px;">
                            <label class="font-weight-bold">RESIDENTIAL ADDRESS</label>
                            <label class="font-weight-bold">ZIP CODE</label>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="form-group col-md-6"><input type="text" class="form-control" name="res_house_block_lot_no" placeholder="House/Block/Lot No."></div>
                                <div class="form-group col-md-6"><input type="text" class="form-control" name="res_street" placeholder="Street"></div>
                                <div class="form-group col-md-6"><input type="text" class="form-control" name="res_subdivision_village" placeholder="Subdivision/Village"></div>
                                <div class="form-group col-md-6"><select name="res_barangay" id="res_barangay" class="form-control select2" data-placeholder="Barangay"></select></div>
                                <div class="form-group col-md-6"><select name="res_city_municipality" id="res_city_municipality" class="form-control select2" data-placeholder="City/Municipality"></select></div>
                                <div class="form-group col-md-6"><select name="res_province" id="res_province" class="form-control select2" data-placeholder="Province"></select></div>
                                <div class="form-group col-md-6"><select name="res_region" id="res_region" class="form-control select2" data-placeholder="Region"></select></div>
                                <div class="form-group col-md-6"><input type="text" class="form-control" name="res_zip_code" placeholder="ZIP CODE"></div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">Next page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('static/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4',
            });

            const populateDropdown = (element, data, textKey, valueKey) => {
                const placeholder = $(element).data('placeholder');
                $(element).empty().append(`<option value="">-- Select ${placeholder} --</option>`);
                data.forEach(item => {
                    $(element).append(new Option(item[textKey], item[valueKey]));
                });
            };

            // Fetch and populate Regions
            fetch('/api/regions')
                .then(response => response.json())
                .then(data => populateDropdown('#res_region', data, 'region_name', 'region_code'));

            // Handle Province dropdown population
            $('#res_region').on('change', function() {
                const regionCode = $(this).val();
                $('#res_province, #res_city_municipality, #res_barangay').empty().append('<option value="">Select...</option>').trigger('change');
                if (regionCode) {
                    fetch(`/api/provinces?region_code=${regionCode}`)
                        .then(response => response.json())
                        .then(data => populateDropdown('#res_province', data, 'province_name', 'province_code'));
                }
            });

            // Handle City/Municipality dropdown population
            $('#res_province').on('change', function() {
                const provinceCode = $(this).val();
                 $('#res_city_municipality, #res_barangay').empty().append('<option value="">Select...</option>').trigger('change');
                if (provinceCode) {
                    fetch(`/api/cities?province_code=${provinceCode}`)
                        .then(response => response.json())
                        .then(data => populateDropdown('#res_city_municipality', data, 'city_municipality_name', 'city_municipality_code'));
                }
            });

            // Handle Barangay dropdown population
            $('#res_city_municipality').on('change', function() {
                const cityCode = $(this).val();
                $('#res_barangay').empty().append('<option value="">Select...</option>').trigger('change');
                if (cityCode) {
                    fetch(`/api/barangays?city_code=${cityCode}`)
                        .then(response => response.json())
                        .then(data => populateDropdown('#res_barangay', data, 'barangay_name', 'barangay_code'));
                }
            });
        });
    </script>
@endpush