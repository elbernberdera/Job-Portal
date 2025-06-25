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
               
                    
                    <h2>All Job Vacancies</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Division</th>
                    <th>Status</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacancies as $vacancy)
                    <tr>
                        <td>{{ $vacancy->job_title }}</td>
                        <td>{{ $vacancy->division }}</td>
                        <td>
                            @if($vacancy->status === 'open')
                                <span class="badge bg-primary">{{ ucfirst($vacancy->status) }}</span>
                            @elseif($vacancy->status === 'closed')
                                <span class="badge bg-danger">{{ ucfirst($vacancy->status) }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($vacancy->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $vacancy->date_posted }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- View Button -->
                                <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $vacancy->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
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
                @endforeach
            </tbody>
        </table>
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
                                    <input type="text" id="job_title_modal" name="job_title" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="position_code_modal" class="form-label">Position Code</label>
                                    <input type="text" id="position_code_modal" name="position_code" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="division_modal" class="form-label">Division</label>
                                    <input type="text" id="division_modal" name="division" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="region_modal" class="form-label">Region</label>
                                    <input type="text" id="region_modal" name="region" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="monthly_salary_modal" class="form-label">Monthly Salary</label>
                                    <input type="number" step="0.01" id="monthly_salary_modal" name="monthly_salary" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="education_modal" class="form-label">Education</label>
                                    <input type="text" id="education_modal" name="education" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="eligibility_modal" class="form-label">Eligibility</label>
                                    <textarea id="eligibility_modal" name="eligibility" class="form-control" rows="1"></textarea>
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
});
</script>
@endsection
