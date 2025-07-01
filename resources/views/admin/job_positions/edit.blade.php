@extends('admin.base.base')

@section('page_title', 'Edit Job Position')

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Job Position</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.job_positions.index') }}">Job Positions</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Job Position: {{ $jobPosition->job_title }}</h3>
            </div>
            <form action="{{ route('admin.job_positions.update', $jobPosition->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            
                            <div class="form-group">
                                <label for="job_title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('job_title') is-invalid @enderror" 
                                       id="job_title" name="job_title" value="{{ old('job_title', $jobPosition->job_title) }}" required>
                                @error('job_title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="position_code">Position Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position_code') is-invalid @enderror" 
                                       id="position_code" name="position_code" value="{{ old('position_code', $jobPosition->position_code) }}" required>
                                @error('position_code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="division">Division <span class="text-danger">*</span></label>
                                <select class="form-control @error('division') is-invalid @enderror" id="division" name="division" required>
                                    <option value="">Select Division</option>
                                    <option value="Admin and Finance" {{ old('division', $jobPosition->division) == 'Admin and Finance' ? 'selected' : '' }}>Admin and Finance</option>
                                    <option value="Technical Operations Division" {{ old('division', $jobPosition->division) == 'Technical Operations Division' ? 'selected' : '' }}>Technical Operations Division</option>
                                    <option value="Office of the Regional Director" {{ old('division', $jobPosition->division) == 'Office of the Regional Director' ? 'selected' : '' }}>Office of the Regional Director</option>
                                </select>
                                @error('division')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="region">Region <span class="text-danger">*</span></label>
                                <select class="form-control @error('region') is-invalid @enderror" id="region" name="region" required>
                                    <option value="">Select Region</option>
                                    <option value="Region I" {{ old('region', $jobPosition->region) == 'Region I' ? 'selected' : '' }}>Region I</option>
                                    <option value="Region II" {{ old('region', $jobPosition->region) == 'Region II' ? 'selected' : '' }}>Region II</option>
                                    <option value="Region III" {{ old('region', $jobPosition->region) == 'Region III' ? 'selected' : '' }}>Region III</option>
                                    <option value="Region IV-A" {{ old('region', $jobPosition->region) == 'Region IV-A' ? 'selected' : '' }}>Region IV-A</option>
                                    <option value="Region IV-B" {{ old('region', $jobPosition->region) == 'Region IV-B' ? 'selected' : '' }}>Region IV-B</option>
                                    <option value="Region V" {{ old('region', $jobPosition->region) == 'Region V' ? 'selected' : '' }}>Region V</option>
                                    <option value="Region VI" {{ old('region', $jobPosition->region) == 'Region VI' ? 'selected' : '' }}>Region VI</option>
                                    <option value="Region VII" {{ old('region', $jobPosition->region) == 'Region VII' ? 'selected' : '' }}>Region VII</option>
                                    <option value="Region VIII" {{ old('region', $jobPosition->region) == 'Region VIII' ? 'selected' : '' }}>Region VIII</option>
                                    <option value="Region IX" {{ old('region', $jobPosition->region) == 'Region IX' ? 'selected' : '' }}>Region IX</option>
                                    <option value="Region X" {{ old('region', $jobPosition->region) == 'Region X' ? 'selected' : '' }}>Region X</option>
                                    <option value="Region XI" {{ old('region', $jobPosition->region) == 'Region XI' ? 'selected' : '' }}>Region XI</option>
                                    <option value="Region XII" {{ old('region', $jobPosition->region) == 'Region XII' ? 'selected' : '' }}>Region XII</option>
                                    <option value="CARAGA" {{ old('region', $jobPosition->region) == 'CARAGA' ? 'selected' : '' }}>CARAGA</option>
                                    <option value="NCR" {{ old('region', $jobPosition->region) == 'NCR' ? 'selected' : '' }}>NCR</option>
                                    <option value="CAR" {{ old('region', $jobPosition->region) == 'CAR' ? 'selected' : '' }}>CAR</option>
                                    <option value="BARMM" {{ old('region', $jobPosition->region) == 'BARMM' ? 'selected' : '' }}>BARMM</option>
                                </select>
                                @error('region')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="monthly_salary">Monthly Salary</label>
                                <input type="number" step="0.01" class="form-control @error('monthly_salary') is-invalid @enderror" 
                                       id="monthly_salary" name="monthly_salary" value="{{ old('monthly_salary', $jobPosition->monthly_salary) }}">
                                @error('monthly_salary')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status and Dates -->
                        <div class="col-md-6">
                            <h5>Status and Dates</h5>
                            
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="open" {{ old('status', $jobPosition->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ old('status', $jobPosition->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="archived" {{ old('status', $jobPosition->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_posted">Date Posted</label>
                                <input type="date" class="form-control @error('date_posted') is-invalid @enderror" 
                                       id="date_posted" name="date_posted" value="{{ old('date_posted', $jobPosition->date_posted ? $jobPosition->date_posted->format('Y-m-d') : '') }}">
                                @error('date_posted')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="closing_date">Closing Date</label>
                                <input type="date" class="form-control @error('closing_date') is-invalid @enderror" 
                                       id="closing_date" name="closing_date" value="{{ old('closing_date', $jobPosition->closing_date ? $jobPosition->closing_date->format('Y-m-d') : '') }}">
                                @error('closing_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Requirements -->
                    <div class="row">
                        <div class="col-12">
                            <h5>Requirements and Qualifications</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="education">Education</label>
                                <textarea class="form-control @error('education') is-invalid @enderror" 
                                          id="education" name="education" rows="3">{{ old('education', $jobPosition->education) }}</textarea>
                                @error('education')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="eligibility">Eligibility</label>
                                <textarea class="form-control @error('eligibility') is-invalid @enderror" 
                                          id="eligibility" name="eligibility" rows="3">{{ old('eligibility', $jobPosition->eligibility) }}</textarea>
                                @error('eligibility')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="min_education_level">Minimum Education Level</label>
                                <select class="form-control @error('min_education_level') is-invalid @enderror" id="min_education_level" name="min_education_level">
                                    <option value="">Select Education Level</option>
                                    <option value="Elementary" {{ old('min_education_level', $jobPosition->min_education_level) == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                                    <option value="High School" {{ old('min_education_level', $jobPosition->min_education_level) == 'High School' ? 'selected' : '' }}>High School</option>
                                    <option value="Vocational" {{ old('min_education_level', $jobPosition->min_education_level) == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                                    <option value="Bachelor's Degree" {{ old('min_education_level', $jobPosition->min_education_level) == 'Bachelor\'s Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="Master's Degree" {{ old('min_education_level', $jobPosition->min_education_level) == 'Master\'s Degree' ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="Doctorate" {{ old('min_education_level', $jobPosition->min_education_level) == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                                </select>
                                @error('min_education_level')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="min_years_experience">Minimum Years of Experience</label>
                                <input type="number" min="0" class="form-control @error('min_years_experience') is-invalid @enderror" 
                                       id="min_years_experience" name="min_years_experience" value="{{ old('min_years_experience', $jobPosition->min_years_experience) }}">
                                @error('min_years_experience')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Job Position
                    </button>
                    <a href="{{ route('admin.job_positions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script>
    // Set minimum date for closing date based on date posted
    document.getElementById('date_posted').addEventListener('change', function() {
        const datePosted = this.value;
        const closingDateInput = document.getElementById('closing_date');
        if (datePosted) {
            closingDateInput.min = datePosted;
        }
    });
</script>
@endsection 