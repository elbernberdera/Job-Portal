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
                <form action="{{ route('user.profile.update') }}" method="POST">
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
                                <select class="form-control @error('suffix') is-invalid @enderror" 
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
                                <select class="form-control select2" id="sex" name="sex" required>
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
                                <select class="form-control custom-chevron" id="civil_status" name="civil_status" required>
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
                <form action="{{ route('user.profile.update') }}" method="POST">
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
                                <select class="form-control @error('suffix') is-invalid @enderror" 
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
@endpush
