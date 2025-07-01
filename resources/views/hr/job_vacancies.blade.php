@extends('hr.base.base')
@section('main_content')
<div class="container">
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

    <!-- Debug information -->
    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">HR</h3>
                    <div class="ms-auto mb-3">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addJobModal">
                            <i class="fas fa-plus"></i> Add Job Vacancy
                        </button>
                    </div>
                </div>
                <div class="card-body">
               
                    
                    <ul class="nav nav-tabs mb-3" id="jobTabs" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-jobs-tab" data-bs-toggle="tab" data-bs-target="#all-jobs" type="button" role="tab" aria-controls="all-jobs" aria-selected="true">All Job Vacancies</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="jobs-posted-tab" data-bs-toggle="tab" data-bs-target="#jobs-posted" type="button" role="tab" aria-controls="jobs-posted" aria-selected="false">Jobs Posted</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="archived-posts-tab" data-bs-toggle="tab" data-bs-target="#archived-posts" type="button" role="tab" aria-controls="archived-posts" aria-selected="false">Archived Posts</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="jobTabsContent">
                      <div class="tab-pane fade show active" id="all-jobs" role="tabpanel" aria-labelledby="all-jobs-tab">
                        <!-- Existing All Job Vacancies table -->
                        <h2>All Job Vacancies</h2>
                        <table class="table table-bordered mt-3">
                          <thead>
                            <tr>
                              <th>Job Title</th>
                              <th>Division</th>
                              <th>Region</th>
                              <th>Status</th>
                              <th>Date Posted</th>
                              <th>Post Until</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($activeVacancies as $vacancy)
                            <tr>
                              <td>{{ $vacancy->job_title }}</td>
                              <td>{{ $vacancy->division }}</td>
                              <td>{{ $vacancy->region }}</td>
                              <td>
                                <span class="badge {{ $vacancy->getStatusBadgeClass() }}">{{ $vacancy->getStatusDisplayText() }}</span>
                              </td>
                              <td>{{ $vacancy->date_posted ? \Carbon\Carbon::parse($vacancy->date_posted)->format('M d, Y') : '-' }}</td>
                              <td>{{ $vacancy->closing_date ? \Carbon\Carbon::parse($vacancy->closing_date)->format('M d, Y') : '-' }}</td>
                              <td>
                                <div class="btn-group" role="group">
                                  <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-eye"></i> View
                                  </button>
                                  <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewApplicantsModal{{ $vacancy->id }}">
                                    <i class="fas fa-users"></i> View Applicants
                                  </button>
                                  <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                  </button>
                                  <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#archiveJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-archive"></i> Archive
                                  </button>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                  </button>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade" id="jobs-posted" role="tabpanel" aria-labelledby="jobs-posted-tab">
                        <h2>Jobs Posted</h2>
                        <table class="table table-bordered mt-3">
                          <thead>
                            <tr>
                              <th>Job Title</th>
                              <th>Division</th>
                              <th>Region</th>
                              <th>Status</th>
                              <th>Date Posted</th>
                              <th>Post Until</th>
                              <th>Applications</th>
                              <th>Shortlisted</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($activeVacancies as $vacancy)
                            <tr>
                              <td>{{ $vacancy->job_title }}</td>
                              <td>{{ $vacancy->division }}</td>
                              <td>{{ $vacancy->region }}</td>
                              <td>
                                <span class="badge {{ $vacancy->getStatusBadgeClass() }}">{{ $vacancy->getStatusDisplayText() }}</span>
                              </td>
                              <td>{{ $vacancy->date_posted ? \Carbon\Carbon::parse($vacancy->date_posted)->format('M d, Y') : '-' }}</td>
                              <td>{{ $vacancy->closing_date ? \Carbon\Carbon::parse($vacancy->closing_date)->format('M d, Y') : '-' }}</td>
                              <td>{{ $vacancy->applications_count }}</td>
                              <td>{{ $vacancy->shortlisted_count }}</td>
                              <td>
                                <div class="btn-group" role="group">
                                  <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-eye"></i> View
                                  </button>
                                  <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewApplicantsModal{{ $vacancy->id }}">
                                    <i class="fas fa-users"></i> View Applicants
                                  </button>
                                  <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                  </button>
                                  <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#archiveJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-archive"></i> Archive
                                  </button>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                  </button>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade" id="archived-posts" role="tabpanel" aria-labelledby="archived-posts-tab">
                        <h2>Archived Posts</h2>
                        <table class="table table-bordered mt-3">
                          <thead>
                            <tr>
                              <th>Job Title</th>
                              <th>Division</th>
                              <th>Region</th>
                              <th>Status</th>
                              <th>Date Posted</th>
                              <th>Post Until</th>
                              <th>Applications</th>
                              <th>Shortlisted</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($archivedVacancies as $vacancy)
                            <tr>
                              <td>{{ $vacancy->job_title }}</td>
                              <td>{{ $vacancy->division }}</td>
                              <td>{{ $vacancy->region }}</td>
                              <td>
                                <span class="badge {{ $vacancy->getStatusBadgeClass() }}">{{ $vacancy->getStatusDisplayText() }}</span>
                              </td>
                              <td>{{ $vacancy->date_posted ? \Carbon\Carbon::parse($vacancy->date_posted)->format('M d, Y') : '-' }}</td>
                              <td>{{ $vacancy->closing_date ? \Carbon\Carbon::parse($vacancy->closing_date)->format('M d, Y') : '-' }}</td>
                              <td>{{ $vacancy->applications_count }}</td>
                              <td>{{ $vacancy->shortlisted_count }}</td>
                              <td>
                                <div class="btn-group" role="group">
                                  <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-eye"></i> View
                                  </button>
                                  <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewApplicantsModal{{ $vacancy->id }}">
                                    <i class="fas fa-users"></i> View Applicants
                                  </button>
                                  <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                  </button>
                                  <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#archiveJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-archive"></i> Archive
                                  </button>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                  </button>
                                </div>
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="9" class="text-center">No archived job vacancies found.</td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('job_vacancies.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addJobModalLabel">Add Job Vacancy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row g-3">
                                <!-- Job Details -->
                                <div class="col-md-6">
                                    <label for="job_title_modal" class="form-label">Job Title</label>
                                    <select id="job_title_modal" name="job_title" class="form-select" required>
                                        <option value="">Select Job Title</option>
                                        <option value="ADAS IV  (Driver II)">ADAS IV  (Driver II)</option>
                                        <option value="Budget Officer II">Budget Officer II</option>
                                        <option value="ITO II - Provincial Officer">ITO II - Provincial Officer</option>
                                        <option value="LINEMAN I - Messenger/Driver">LINEMAN I - Messenger/Driver</option>
                                        <option value="Cashier II">Cashier II</option>
                                        <option value="ITO I">ITO I</option>
                                        <option value="ENG3 - Provincial Officer ADS">ENG3 - Provincial Officer ADS</option>
                                        <option value="Director IV - Regional Director">Director IV - Regional Director</option>
                                        <option value="ITO I">ITO I</option>
                                        <option value="ENG3 - Provincial Officer ADN">ENG3 - Provincial Officer ADN</option>
                                        <option value="Accountant III">Accountant III</option>
                                        <option value="CEO III - Support Staff">CEO III - Support Staff</option>
                                        <option value="ITO II - Provincial Officer PDI">ITO II - Provincial Officer PDI</option>
                                        <option value="ADAS 3">ADAS 3</option>
                                        <option value="ECET I">ECET I</option>
                                        <option value="ITO I- Provincial Officer SDS">ITO I- Provincial Officer SDS</option>
                                        <option value="Driver II">Driver II</option>
                                        <option value="ADAS IV  (Driver II)">ADAS IV  (Driver II)</option>
                                        <option value="ITO III - TOD Chief">ITO III - TOD Chief</option>
                                        <option value="HRMO II">HRMO II</option>
                                        <option value="ITO I - Section Head, IIDB">ITO I - Section Head, IIDB</option>
                                        <option value="ISA I">ISA I</option>
                                        <option value="ITO 2 - Section Head, Connectivity">ITO 2 - Section Head, Connectivity</option>
                                        <option value="Chief Administrative Officer">Chief Administrative Officer</option>
                                        <option value="PDO I">PDO I</option>
                                        <option value="PDO II">PDO II</option>
                                        <option value="ENGINEER II">ENGINEER II</option>
                                        <option value="ENGR II">ENGR II</option>
                                        <option value="ENGR I">ENGR I</option>
                                        <option value="ISA II">ISA II</option>
                                        <option value="PLO II">PLO II</option>
                                        <option value="PMO I">PMO I</option>
                                        <option value="ENGR III">ENGR III</option>
                                        <option value="PLA">PLA</option>
                                        <option value="PLO I">PLO I</option>
                                        <option value="Supply Officer I">Supply Officer I</option>
                                        <option value="Administrative Officer II">Administrative Officer II</option>
                                        <option value="Administrative Aide IV (Utility)">Administrative Aide IV (Utility)</option>
                                        <option value="Administrative Aide IV (AA IV)">Administrative Aide IV (AA IV)</option>
                                        <option value="Administrative Officer II (HRMO I)">Administrative Officer II (HRMO I)</option>
                                        <option value="Administrative Officer II (Budget Officer I)">Administrative Officer II (Budget Officer I)</option>
                                        <option value="Administrative Officer I (Cashier I)">Administrative Officer I (Cashier I)</option>
                                        <option value="Records Officer I">Records Officer I</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="position_code_modal" class="form-label">Position Code</label>
                                    <input type="text" id="position_code_modal" name="position_code" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="division_modal" class="form-label">Division</label>
                                    <select id="division_modal" name="division" class="form-select" required>
                                        <option value="">Select Division</option>
                                        <option value="Admin and Finance">Admin and Finance</option>
                                        <option value="Technical Operations Division">Technical Operations Division</option>
                                        <option value="Office of the Regional Director">Office of the Regional Director</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="region_modal" class="form-label">Region</label>
                                    <select id="region_modal" name="region" class="form-select" required>
                                        <option value="">Select Region</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="salary_grade_modal" class="form-label">Salary Grade</label>
                                    <select id="salary_grade_modal" name="salary_grade" class="form-select" required>
                                        <option value="">Select Salary Grade</option>
                                        @for ($i = 1; $i <= 33; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="monthly_salary_modal" class="form-label mt-2">Monthly Salary (Step 1)</label>
                                    <input type="number" step="0.01" id="monthly_salary_modal" name="monthly_salary" class="form-control" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="education_modal" class="form-label">Education</label>
                                    <select id="education_modal" name="education" class="form-select" required>
                                        <option value="College Graduate">College Graduate</option>
                                        <option value="Undergrad">Undergrad</option>
                                        <option value="TESDA Graduate">TESDA Graduate</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="eligibility_modal" class="form-label">Eligibility</label>
                                    <select id="eligibility_modal" name="eligibility" class="form-select" required>
                                        <option value="CSC Sub-prof">CSC Sub-prof</option>
                                        <option value="CSC Prof">CSC Prof</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="status_modal" class="form-label">Status</label>
                                    <select id="status_modal" name="status" class="form-select" required>
                                        <option value="open" selected>Open</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_posted_modal" class="form-label">Date Posted</label>
                                    <input type="date" id="date_posted_modal" name="date_posted" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="closing_date_modal" class="form-label">Accepting Applications Until</label>
                                    <input type="date" id="closing_date_modal" name="closing_date" class="form-control">
                                </div>
                                <div class="col-12"><hr class="my-4"></div>
                                <div class="col-12">
                                    <h5>Qualification Criteria</h5>
                                </div>
                                <div class="col-md-6">
                                    <label for="required_course_modal" class="form-label">Required Course/Degree</label>
                                    <input type="text" id="required_course_modal" name="required_course" class="form-control" placeholder="e.g. BS Computer Science">
                                </div>
                                <div class="col-md-6">
                                    <label for="min_years_experience_modal" class="form-label">Minimum Years of Experience</label>
                                    <input type="number" id="min_years_experience_modal" name="min_years_experience" class="form-control" min="0" placeholder="e.g. 2">
                                </div>
                                <div class="col-md-6">
                                    <label for="required_skills_modal" class="form-label">Required Skills (comma separated)</label>
                                    <input type="text" id="required_skills_modal" name="required_skills" class="form-control" placeholder="e.g. Programming, Communication">
                                </div>
                                <div class="col-md-6">
                                    <label for="citizenship_requirement_modal" class="form-label">Citizenship Requirement</label>
                                    <input type="text" id="citizenship_requirement_modal" name="citizenship_requirement" class="form-control" placeholder="e.g. Filipino">
                                </div>

                                <!-- <div class="col-12"><hr class="my-4"></div> -->

                                <!-- Dynamic Fields Section -->
                                <div class="col-md-6">
                                    <h5>Training</h5>
                                    <div id="training-list-modal">
                                        <!-- Dynamic training inputs will be added here -->
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-training-modal">Add Training</button>
                                </div>

                                <div class="col-md-6">
                                    <h5>Experience</h5>
                                    <div id="experience-list-modal">
                                        <!-- Dynamic experience inputs will be added here -->
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-experience-modal">Add Experience</button>
                                </div>

                                <div class="col-md-6">
                                    <h5>Benefits</h5>
                                    <div id="benefits-list-modal">
                                        <!-- Dynamic benefits inputs will be added here -->
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-benefit-modal">Add Benefit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Job Vacancy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>

</div>
<script>
const salaryTable = [
  null, // index 0 unused
  14061, 14925, 15852, 16833, 17866, 18957, 20110, 21448, 23226, 25586, 30304, 32245, 34421, 37024, 40028, 43560, 47427, 51804, 56930, 62967, 70013, 78166, 87315, 98185, 111727, 126252, 142663, 160469, 180492, 203200, 293191, 347888, 438844
];

document.addEventListener('DOMContentLoaded', function() {
    // Add Benefit
    let benefitIndexModal = 0;
    document.getElementById('add-benefit-modal').addEventListener('click', function() {
        const list = document.getElementById('benefits-list-modal');
        const item = document.createElement('div');
        item.className = 'benefit-item mb-2';
        item.innerHTML = `
            <div class="input-group">
                <input type="number" step="0.01" name="benefits[${benefitIndexModal}][amount]" placeholder="Amount" class="form-control me-2" style="max-width: 120px;">
                <textarea name="benefits[${benefitIndexModal}][description]" placeholder="Description" class="form-control" rows="1"></textarea>
                <button type="button" class="btn btn-danger btn-sm remove-benefit">X</button>
            </div>`;
        list.appendChild(item);
        benefitIndexModal++;
    });

    // Add Training
    let trainingIndexModal = 0;
    document.getElementById('add-training-modal').addEventListener('click', function() {
        const list = document.getElementById('training-list-modal');
        const item = document.createElement('div');
        item.className = 'training-item mb-2';
        item.innerHTML = `
            <div class="input-group">
                <input type="text" name="training[${trainingIndexModal}]" class="form-control" placeholder="Training">
                <button type="button" class="btn btn-danger btn-sm remove-training">X</button>
            </div>`;
        list.appendChild(item);
        trainingIndexModal++;
    });

    // Add Experience
    let experienceIndexModal = 0;
    document.getElementById('add-experience-modal').addEventListener('click', function() {
        const list = document.getElementById('experience-list-modal');
        const item = document.createElement('div');
        item.className = 'experience-item mb-2';
        item.innerHTML = `
            <div class="input-group">
                <input type="text" name="experience[${experienceIndexModal}]" class="form-control" placeholder="Experience">
                <button type="button" class="btn btn-danger btn-sm remove-experience">X</button>
            </div>`;
        list.appendChild(item);
        experienceIndexModal++;
    });

    // Remove buttons event delegation
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-benefit') || e.target.classList.contains('remove-training') || e.target.classList.contains('remove-experience')) {
            e.target.closest('.input-group').parentElement.remove();
        }
    });

    // Populate regions for job modal
    fetch('/regions')
      .then(response => response.json())
      .then(data => {
        const regionSelect = document.getElementById('region_modal');
        if (regionSelect && data.regions) {
          regionSelect.innerHTML = '<option value="">Select Region</option>';
          data.regions.forEach(region => {
            regionSelect.innerHTML += `<option value="${region.name}">${region.name}</option>`;
          });
        }
      });

    const gradeSelect = document.getElementById('salary_grade_modal');
    const salaryInput = document.getElementById('monthly_salary_modal');
    if (gradeSelect && salaryInput) {
        gradeSelect.addEventListener('change', function() {
            const grade = parseInt(this.value);
            if (salaryTable[grade]) {
                salaryInput.value = salaryTable[grade];
            } else {
                salaryInput.value = '';
            }
        });
    }
});
</script>
@endsection

@foreach($activeVacancies as $vacancy)
    <!-- View Modal -->
    <div class="modal fade" id="viewJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="viewJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalLabel{{ $vacancy->id }}">Job Vacancy Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Job Title:</strong> {{ $vacancy->job_title }}</li>
                        <li class="list-group-item"><strong>Position Code:</strong> {{ $vacancy->position_code }}</li>
                        <li class="list-group-item"><strong>Division:</strong> {{ $vacancy->division }}</li>
                        <li class="list-group-item"><strong>Region:</strong> {{ $vacancy->region }}</li>
                        <li class="list-group-item"><strong>Monthly Salary:</strong> {{ $vacancy->monthly_salary }}</li>
                        <li class="list-group-item"><strong>Education:</strong> {{ $vacancy->education }}</li>
                        <li class="list-group-item"><strong>Training:</strong>
                            @if(is_array($vacancy->training) && count($vacancy->training))
                                <ul>
                                    @foreach($vacancy->training as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Experience:</strong>
                            @if(is_array($vacancy->experience) && count($vacancy->experience))
                                <ul>
                                    @foreach($vacancy->experience as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Eligibility:</strong> {{ $vacancy->eligibility }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($vacancy->status) }}</li>
                        <li class="list-group-item"><strong>Date Posted:</strong> {{ $vacancy->date_posted }}</li>
                        <li class="list-group-item"><strong>Benefits:</strong>
                            @if(is_array($vacancy->benefits) && count($vacancy->benefits))
                                <ul>
                                    @foreach($vacancy->benefits as $benefit)
                                        <li>{{ $benefit['amount'] ?? '' }} - {{ $benefit['description'] ?? '' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="editJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('job_vacancies.update', $vacancy->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editJobModalLabel{{ $vacancy->id }}">Edit Job Vacancy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="job_title_edit_{{ $vacancy->id }}" class="form-label">Job Title</label>
                                    <select id="job_title_edit_{{ $vacancy->id }}" name="job_title" class="form-select" required>
                                        <option value="">Select Job Title</option>
                                        <option value="ADAS IV  (Driver II)">ADAS IV  (Driver II)</option>
                                        <option value="Budget Officer II">Budget Officer II</option>
                                        <option value="ITO II - Provincial Officer">ITO II - Provincial Officer</option>
                                        <option value="LINEMAN I - Messenger/Driver">LINEMAN I - Messenger/Driver</option>
                                        <option value="Cashier II">Cashier II</option>
                                        <option value="ITO I">ITO I</option>
                                        <option value="ENG3 - Provincial Officer ADS">ENG3 - Provincial Officer ADS</option>
                                        <option value="Director IV - Regional Director">Director IV - Regional Director</option>
                                        <option value="ITO I">ITO I</option>
                                        <option value="ENG3 - Provincial Officer ADN">ENG3 - Provincial Officer ADN</option>
                                        <option value="Accountant III">Accountant III</option>
                                        <option value="CEO III - Support Staff">CEO III - Support Staff</option>
                                        <option value="ITO II - Provincial Officer PDI">ITO II - Provincial Officer PDI</option>
                                        <option value="ADAS 3">ADAS 3</option>
                                        <option value="ECET I">ECET I</option>
                                        <option value="ITO I- Provincial Officer SDS">ITO I- Provincial Officer SDS</option>
                                        <option value="Driver II">Driver II</option>
                                        <option value="ADAS IV  (Driver II)">ADAS IV  (Driver II)</option>
                                        <option value="ITO III - TOD Chief">ITO III - TOD Chief</option>
                                        <option value="HRMO II">HRMO II</option>
                                        <option value="ITO I - Section Head, IIDB">ITO I - Section Head, IIDB</option>
                                        <option value="ISA I">ISA I</option>
                                        <option value="ITO 2 - Section Head, Connectivity">ITO 2 - Section Head, Connectivity</option>
                                        <option value="Chief Administrative Officer">Chief Administrative Officer</option>
                                        <option value="PDO I">PDO I</option>
                                        <option value="PDO II">PDO II</option>
                                        <option value="ENGINEER II">ENGINEER II</option>
                                        <option value="ENGR II">ENGR II</option>
                                        <option value="ENGR I">ENGR I</option>
                                        <option value="ISA II">ISA II</option>
                                        <option value="PLO II">PLO II</option>
                                        <option value="PMO I">PMO I</option>
                                        <option value="ENGR III">ENGR III</option>
                                        <option value="PLA">PLA</option>
                                        <option value="PLO I">PLO I</option>
                                        <option value="Supply Officer I">Supply Officer I</option>
                                        <option value="Administrative Officer II">Administrative Officer II</option>
                                        <option value="Administrative Aide IV (Utility)">Administrative Aide IV (Utility)</option>
                                        <option value="Administrative Aide IV (AA IV)">Administrative Aide IV (AA IV)</option>
                                        <option value="Administrative Officer II (HRMO I)">Administrative Officer II (HRMO I)</option>
                                        <option value="Administrative Officer II (Budget Officer I)">Administrative Officer II (Budget Officer I)</option>
                                        <option value="Administrative Officer I (Cashier I)">Administrative Officer I (Cashier I)</option>
                                        <option value="Records Officer I">Records Officer I</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="position_code_edit_{{ $vacancy->id }}" class="form-label">Position Code</label>
                                    <input type="text" id="position_code_edit_{{ $vacancy->id }}" name="position_code" class="form-control" value="{{ $vacancy->position_code }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="division_edit_{{ $vacancy->id }}" class="form-label">Division</label>
                                    <select id="division_edit_{{ $vacancy->id }}" name="division" class="form-select" required>
                                        <option value="">Select Division</option>
                                        <option value="Admin and Finance">Admin and Finance</option>
                                        <option value="Technical Operations Division">Technical Operations Division</option>
                                        <option value="Office of the Regional Director">Office of the Regional Director</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="region_edit_{{ $vacancy->id }}" class="form-label">Region</label>
                                    <select id="region_edit_{{ $vacancy->id }}" name="region" class="form-select" required>
                                        <option value="">Select Region</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="salary_grade_edit_{{ $vacancy->id }}" class="form-label">Salary Grade</label>
                                    <select id="salary_grade_edit_{{ $vacancy->id }}" name="salary_grade" class="form-select" required>
                                        <option value="">Select Salary Grade</option>
                                        @for ($i = 1; $i <= 33; $i++)
                                            <option value="{{ $i }}" {{ $vacancy->salary_grade == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="monthly_salary_edit_{{ $vacancy->id }}" class="form-label mt-2">Monthly Salary (Step 1)</label>
                                    <input type="number" step="0.01" id="monthly_salary_edit_{{ $vacancy->id }}" name="monthly_salary" class="form-control" value="{{ $vacancy->monthly_salary }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="education_edit_{{ $vacancy->id }}" class="form-label">Education</label>
                                    <select id="education_edit_{{ $vacancy->id }}" name="education" class="form-select" required>
                                        <option value="College Graduate" {{ $vacancy->education == 'College Graduate' ? 'selected' : '' }}>College Graduate</option>
                                        <option value="Undergrad" {{ $vacancy->education == 'Undergrad' ? 'selected' : '' }}>Undergrad</option>
                                        <option value="TESDA Graduate" {{ $vacancy->education == 'TESDA Graduate' ? 'selected' : '' }}>TESDA Graduate</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="eligibility_edit_{{ $vacancy->id }}" class="form-label">Eligibility</label>
                                    <select id="eligibility_edit_{{ $vacancy->id }}" name="eligibility" class="form-select" required>
                                        <option value="CSC Sub-prof" {{ $vacancy->eligibility == 'CSC Sub-prof' ? 'selected' : '' }}>CSC Sub-prof</option>
                                        <option value="CSC Prof" {{ $vacancy->eligibility == 'CSC Prof' ? 'selected' : '' }}>CSC Prof</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="status_edit_{{ $vacancy->id }}" class="form-label">Status</label>
                                    <select id="status_edit_{{ $vacancy->id }}" name="status" class="form-select" required>
                                        <option value="open" {{ $vacancy->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="closed" {{ $vacancy->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="archived" {{ $vacancy->status == 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_posted_edit_{{ $vacancy->id }}" class="form-label">Date Posted</label>
                                    <input type="date" id="date_posted_edit_{{ $vacancy->id }}" name="date_posted" class="form-control" value="{{ $vacancy->date_posted }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="closing_date_edit_{{ $vacancy->id }}" class="form-label">Accepting Applications Until</label>
                                    <input type="date" id="closing_date_edit_{{ $vacancy->id }}" name="closing_date" class="form-control" value="{{ $vacancy->closing_date }}">
                                </div>
                                <div class="col-12"><hr class="my-4"></div>
                                <div class="col-12">
                                    <h5>Qualification Criteria</h5>
                                </div>
                                <div class="col-md-6">
                                    <label for="required_course_edit_{{ $vacancy->id }}" class="form-label">Required Course/Degree</label>
                                    <input type="text" id="required_course_edit_{{ $vacancy->id }}" name="required_course" class="form-control" value="{{ $vacancy->required_course }}" placeholder="e.g. BS Computer Science">
                                </div>
                                <div class="col-md-6">
                                    <label for="min_years_experience_edit_{{ $vacancy->id }}" class="form-label">Minimum Years of Experience</label>
                                    <input type="number" id="min_years_experience_edit_{{ $vacancy->id }}" name="min_years_experience" class="form-control" min="0" value="{{ $vacancy->min_years_experience }}" placeholder="e.g. 2">
                                </div>
                                <div class="col-md-6">
                                    <label for="required_skills_edit_{{ $vacancy->id }}" class="form-label">Required Skills (comma separated)</label>
                                    <input type="text" id="required_skills_edit_{{ $vacancy->id }}" name="required_skills" class="form-control" value="{{ is_array($vacancy->required_skills) ? implode(', ', $vacancy->required_skills) : $vacancy->required_skills }}" placeholder="e.g. Programming, Communication">
                                </div>
                                <div class="col-md-6">
                                    <label for="citizenship_requirement_edit_{{ $vacancy->id }}" class="form-label">Citizenship Requirement</label>
                                    <input type="text" id="citizenship_requirement_edit_{{ $vacancy->id }}" name="citizenship_requirement" class="form-control" value="{{ $vacancy->citizenship_requirement }}" placeholder="e.g. Filipino">
                                </div>

                                <!-- Dynamic Fields Section -->
                                <div class="col-md-6">
                                    <h5>Training</h5>
                                    <div id="training-list-edit-{{ $vacancy->id }}">
                                        @if(is_array($vacancy->training) && count($vacancy->training))
                                            @foreach($vacancy->training as $idx => $item)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="training[{{ $idx }}]" class="form-control" value="{{ $item }}" placeholder="Training">
                                                    <button type="button" class="btn btn-danger btn-sm remove-training">X</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2 add-training-edit" data-target="training-list-edit-{{ $vacancy->id }}">Add Training</button>
                                </div>

                                <div class="col-md-6">
                                    <h5>Experience</h5>
                                    <div id="experience-list-edit-{{ $vacancy->id }}">
                                        @if(is_array($vacancy->experience) && count($vacancy->experience))
                                            @foreach($vacancy->experience as $idx => $item)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="experience[{{ $idx }}]" class="form-control" value="{{ $item }}" placeholder="Experience">
                                                    <button type="button" class="btn btn-danger btn-sm remove-experience">X</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2 add-experience-edit" data-target="experience-list-edit-{{ $vacancy->id }}">Add Experience</button>
                                </div>

                                <div class="col-md-6">
                                    <h5>Benefits</h5>
                                    <div id="benefits-list-edit-{{ $vacancy->id }}">
                                        @if(is_array($vacancy->benefits) && count($vacancy->benefits))
                                            @foreach($vacancy->benefits as $idx => $benefit)
                                                <div class="input-group mb-2">
                                                    <input type="number" step="0.01" name="benefits[{{ $idx }}][amount]" placeholder="Amount" class="form-control me-2" style="max-width: 120px;" value="{{ $benefit['amount'] ?? '' }}">
                                                    <textarea name="benefits[{{ $idx }}][description]" placeholder="Description" class="form-control" rows="1">{{ $benefit['description'] ?? '' }}</textarea>
                                                    <button type="button" class="btn btn-danger btn-sm remove-benefit">X</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2 add-benefit-edit" data-target="benefits-list-edit-{{ $vacancy->id }}">Add Benefit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="deleteJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteJobModalLabel{{ $vacancy->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the job vacancy "{{ $vacancy->job_title }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('job_vacancies.destroy', $vacancy->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Archive Modal -->
    <div class="modal fade" id="archiveJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="archiveJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveJobModalLabel{{ $vacancy->id }}">Confirm Archive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to archive the job vacancy "{{ $vacancy->job_title }}"?</p>
                    <p class="text-muted">This will move the job to the archived posts section.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('job_vacancies.archive', $vacancy->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Applicants Modals -->
    <div class="modal fade" id="viewApplicantsModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="viewApplicantsModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicantsModalLabel{{ $vacancy->id }}">Qualified Applicants for {{ $vacancy->job_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Date Applied</th>
                                    <th>Qualification Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $qualifiedApplicants = collect();
                                    foreach($vacancy->jobApplications as $application) {
                                        $result = $vacancy->checkQualification($application->user);
                                        if (is_array($result) && isset($result['qualified']) && $result['qualified']) {
                                            $qualifiedApplicants->push([
                                                'application' => $application,
                                                'result' => $result
                                            ]);
                                        }
                                    }
                                @endphp
                                @forelse($qualifiedApplicants as $item)
                                    <tr>
                                        <td>{{ $item['application']->user->first_name }} {{ $item['application']->user->last_name }}</td>
                                        <td>{{ $item['application']->user->email }}</td>
                                        <td>{{ $item['application']->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $item['result']['percentage'] }}%</span>
                                            <small class="text-muted d-block">Score: {{ $item['result']['score'] }}/{{ $item['result']['total_criteria'] }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.profile.show', $item['application']->user->id) }}" class="btn btn-info btn-sm" title="View PDS" target="_blank">
                                                <i class="fas fa-id-card"></i> View PDS
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No qualified applicants found for this position.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($archivedVacancies as $vacancy)
    <!-- View Modal for Archived Jobs -->
    <div class="modal fade" id="viewJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="viewJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalLabel{{ $vacancy->id }}">Job Vacancy Details (Archived)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Job Title:</strong> {{ $vacancy->job_title }}</li>
                        <li class="list-group-item"><strong>Position Code:</strong> {{ $vacancy->position_code }}</li>
                        <li class="list-group-item"><strong>Division:</strong> {{ $vacancy->division }}</li>
                        <li class="list-group-item"><strong>Region:</strong> {{ $vacancy->region }}</li>
                        <li class="list-group-item"><strong>Monthly Salary:</strong> {{ $vacancy->monthly_salary }}</li>
                        <li class="list-group-item"><strong>Education:</strong> {{ $vacancy->education }}</li>
                        <li class="list-group-item"><strong>Training:</strong>
                            @if(is_array($vacancy->training) && count($vacancy->training))
                                <ul>
                                    @foreach($vacancy->training as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Experience:</strong>
                            @if(is_array($vacancy->experience) && count($vacancy->experience))
                                <ul>
                                    @foreach($vacancy->experience as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Eligibility:</strong> {{ $vacancy->eligibility }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($vacancy->status) }}</li>
                        <li class="list-group-item"><strong>Date Posted:</strong> {{ $vacancy->date_posted }}</li>
                        <li class="list-group-item"><strong>Benefits:</strong>
                            @if(is_array($vacancy->benefits) && count($vacancy->benefits))
                                <ul>
                                    @foreach($vacancy->benefits as $benefit)
                                        <li>{{ $benefit['amount'] ?? '' }} - {{ $benefit['description'] ?? '' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>-</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal for Archived Jobs -->
    <div class="modal fade" id="deleteJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="deleteJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteJobModalLabel{{ $vacancy->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the archived job vacancy "{{ $vacancy->job_title }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('job_vacancies.destroy', $vacancy->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Restore Modal -->
    <div class="modal fade" id="restoreJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="restoreJobModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreJobModalLabel{{ $vacancy->id }}">Confirm Restore</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to restore the job vacancy "{{ $vacancy->job_title }}"?</p>
                    <p class="text-muted">This will move the job back to the active jobs section.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('job_vacancies.restore', $vacancy->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Applicants Modals -->
    <div class="modal fade" id="viewApplicantsModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="viewApplicantsModalLabel{{ $vacancy->id }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicantsModalLabel{{ $vacancy->id }}">Qualified Applicants for {{ $vacancy->job_title }} (Archived)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Date Applied</th>
                                    <th>Qualification Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $qualifiedApplicants = collect();
                                    foreach($vacancy->jobApplications as $application) {
                                        $result = $vacancy->checkQualification($application->user);
                                        if (is_array($result) && isset($result['qualified']) && $result['qualified']) {
                                            $qualifiedApplicants->push([
                                                'application' => $application,
                                                'result' => $result
                                            ]);
                                        }
                                    }
                                @endphp
                                @forelse($qualifiedApplicants as $item)
                                    <tr>
                                        <td>{{ $item['application']->user->first_name }} {{ $item['application']->user->last_name }}</td>
                                        <td>{{ $item['application']->user->email }}</td>
                                        <td>{{ $item['application']->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $item['result']['percentage'] }}%</span>
                                            <small class="text-muted d-block">Score: {{ $item['result']['score'] }}/{{ $item['result']['total_criteria'] }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.profile.show', $item['application']->user->id) }}" class="btn btn-info btn-sm" title="View PDS" target="_blank">
                                                <i class="fas fa-id-card"></i> View PDS
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No qualified applicants found for this position.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Populate regions for each edit modal
    @foreach($activeVacancies as $vacancy)
    fetch('/regions')
      .then(response => response.json())
      .then(data => {
        const regionSelect = document.getElementById('region_edit_{{ $vacancy->id }}');
        if (regionSelect && data.regions) {
          regionSelect.innerHTML = '<option value="">Select Region</option>';
          data.regions.forEach(region => {
            regionSelect.innerHTML += `<option value="${region.name}"${region.name === @json($vacancy->region) ? ' selected' : ''}>${region.name}</option>`;
          });
        }
      });
    @endforeach

    @foreach($archivedVacancies as $vacancy)
    fetch('/regions')
      .then(response => response.json())
      .then(data => {
        const regionSelect = document.getElementById('region_edit_{{ $vacancy->id }}');
        if (regionSelect && data.regions) {
          regionSelect.innerHTML = '<option value="">Select Region</option>';
          data.regions.forEach(region => {
            regionSelect.innerHTML += `<option value="${region.name}"${region.name === @json($vacancy->region) ? ' selected' : ''}>${region.name}</option>`;
          });
        }
      });
    @endforeach

    // Salary grade and monthly salary for each edit modal
    const salaryTable = [
      null, 14061, 14925, 15852, 16833, 17866, 18957, 20110, 21448, 23226, 25586, 30304, 32245, 34421, 37024, 40028, 43560, 47427, 51804, 56930, 62967, 70013, 78166, 87315, 98185, 111727, 126252, 142663, 160469, 180492, 203200, 293191, 347888, 438844
    ];
    
    @foreach($activeVacancies as $vacancy)
    const gradeSelectEdit{{ $vacancy->id }} = document.getElementById('salary_grade_edit_{{ $vacancy->id }}');
    const salaryInputEdit{{ $vacancy->id }} = document.getElementById('monthly_salary_edit_{{ $vacancy->id }}');
    if (gradeSelectEdit{{ $vacancy->id }} && salaryInputEdit{{ $vacancy->id }}) {
        gradeSelectEdit{{ $vacancy->id }}.addEventListener('change', function() {
            const grade = parseInt(this.value);
            if (salaryTable[grade]) {
                salaryInputEdit{{ $vacancy->id }}.value = salaryTable[grade];
            } else {
                salaryInputEdit{{ $vacancy->id }}.value = '';
            }
        });
    }
    @endforeach

    @foreach($archivedVacancies as $vacancy)
    const gradeSelectEditArchived{{ $vacancy->id }} = document.getElementById('salary_grade_edit_{{ $vacancy->id }}');
    const salaryInputEditArchived{{ $vacancy->id }} = document.getElementById('monthly_salary_edit_{{ $vacancy->id }}');
    if (gradeSelectEditArchived{{ $vacancy->id }} && salaryInputEditArchived{{ $vacancy->id }}) {
        gradeSelectEditArchived{{ $vacancy->id }}.addEventListener('change', function() {
            const grade = parseInt(this.value);
            if (salaryTable[grade]) {
                salaryInputEditArchived{{ $vacancy->id }}.value = salaryTable[grade];
            } else {
                salaryInputEditArchived{{ $vacancy->id }}.value = '';
            }
        });
    }
    @endforeach

    // Dynamic fields for edit modals
    document.querySelectorAll('.add-training-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.getAttribute('data-target'));
            const idx = target.querySelectorAll('.input-group').length;
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `<input type="text" name="training[${idx}]" class="form-control" placeholder="Training"><button type="button" class="btn btn-danger btn-sm remove-training">X</button>`;
            target.appendChild(div);
        });
    });
    document.querySelectorAll('.add-experience-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.getAttribute('data-target'));
            const idx = target.querySelectorAll('.input-group').length;
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `<input type="text" name="experience[${idx}]" class="form-control" placeholder="Experience"><button type="button" class="btn btn-danger btn-sm remove-experience">X</button>`;
            target.appendChild(div);
        });
    });
    document.querySelectorAll('.add-benefit-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.getAttribute('data-target'));
            const idx = target.querySelectorAll('.input-group').length;
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `<input type="number" step="0.01" name="benefits[${idx}][amount]" placeholder="Amount" class="form-control me-2" style="max-width: 120px;"><textarea name="benefits[${idx}][description]" placeholder="Description" class="form-control" rows="1"></textarea><button type="button" class="btn btn-danger btn-sm remove-benefit">X</button>`;
            target.appendChild(div);
        });
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-benefit') || e.target.classList.contains('remove-training') || e.target.classList.contains('remove-experience')) {
            e.target.closest('.input-group').remove();
        }
    });
});
</script>
