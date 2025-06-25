@extends('hr.base.base')
@section('main_content')
<div class="container">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Job Title</strong></label>
                                                <input type="text" name="job_title" class="form-control" value="{{ $vacancy->job_title }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Position Code</strong></label>
                                                <input type="text" name="position_code" class="form-control" value="{{ $vacancy->position_code }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Division</strong></label>
                                                <input type="text" name="division" class="form-control" value="{{ $vacancy->division }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Region</strong></label>
                                                <input type="text" name="region" class="form-control" value="{{ $vacancy->region }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Monthly Salary</strong></label>
                                                <input type="number" name="monthly_salary" class="form-control" value="{{ $vacancy->monthly_salary }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Education</strong></label>
                                                <input type="text" name="education" class="form-control" value="{{ $vacancy->education }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Eligibility</strong></label>
                                                <input type="text" name="eligibility" class="form-control" value="{{ $vacancy->eligibility }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Status</strong></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="open" {{ $vacancy->status == 'open' ? 'selected' : '' }}>Open</option>
                                                    <option value="closed" {{ $vacancy->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Date Posted</strong></label>
                                                <input type="date" name="date_posted" class="form-control" value="{{ $vacancy->date_posted }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Training</strong></label>
                                                <div id="edit-training-list-{{ $vacancy->id }}">
                                                    @php
                                                        $trainings = is_array($vacancy->training) ? $vacancy->training : [];
                                                    @endphp
                                                    @foreach($trainings as $i => $training)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="training[]" class="form-control" value="{{ $training }}">
                                                            <button type="button" class="btn btn-danger remove-training">Delete</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-outline-success" id="add-training-btn-{{ $vacancy->id }}">Add Training</button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Experience</strong></label>
                                                <div id="edit-experience-list-{{ $vacancy->id }}">
                                                    @php
                                                        $experiences = is_array($vacancy->experience) ? $vacancy->experience : [];
                                                    @endphp
                                                    @foreach($experiences as $i => $experience)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="experience[]" class="form-control" value="{{ $experience }}"></input>
                                                            <button type="button" class="btn btn-danger remove-experience">Delete</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-outline-success" id="add-experience-btn-{{ $vacancy->id }}">Add Experience</button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label><strong>Benefits</strong></label>
                                                <div id="edit-benefits-list-{{ $vacancy->id }}">
                                                    @php
                                                        $benefits = is_array($vacancy->benefits) ? $vacancy->benefits : [];
                                                    @endphp
                                                    @foreach($benefits as $i => $benefit)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="benefits[{{ $i }}][amount]" class="form-control me-2" style="max-width: 120px;" placeholder="Amount" value="{{ $benefit['amount'] ?? '' }}">
                                                            <textarea name="benefits[{{ $i }}][description]" class="form-control" placeholder="Description" rows="1">{{ $benefit['description'] ?? '' }}</textarea>
                                                            <button type="button" class="btn btn-danger remove-benefit">Delete</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-outline-success" id="add-benefit-btn-{{ $vacancy->id }}">Add Benefit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






                <!-- Delete Modal -->
                <div class="modal fade" id="deleteJobModal{{ $vacancy->id }}" tabindex="-1" aria-labelledby="deleteJobModalLabel{{ $vacancy->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('job_vacancies.destroy', $vacancy->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteJobModalLabel{{ $vacancy->id }}">Delete Job Vacancy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this job vacancy?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
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
