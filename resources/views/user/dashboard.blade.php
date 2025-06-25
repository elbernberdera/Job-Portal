@extends('user.base.base')


@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <!-- Breadcrumb or other header content can go here -->
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Open Jobs -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $openJobs ?? 0 }}</h3>
                        <p>Open Job Vacancies</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Applied -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $appliedJobs ?? 0 }}</h3>
                        <p>Jobs You've Applied For</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Failed -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $failedJobs ?? 0 }}</h3>
                        <p>Applications Failed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>


      
                    <div class="card-body">
                        @if($openJobVacancies->isEmpty())
                            <div class="alert alert-info">No open job vacancies at the moment.</div>
                        @else
                            <div class="row">
                                @foreach($openJobVacancies as $index => $job)
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="card h-100">
                                            <div class="card-header text-center">
                                                <h3 class="card-title">Job Vacancies</h3>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Position:</strong> {{ $job->job_title }}</p>
                                                <p><strong>Division:</strong> {{ $job->division }}</p>
                                                <p><strong>Region:</strong> {{ $job->region }}</p>
                                                <p><strong>Monthly Salary:</strong> {{ $job->monthly_salary }}</p>
                                                <p><strong>Date Posted:</strong> {{ $job->date_posted }}</p>
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#viewJobModal{{ $job->id }}">View</a>
                                                    <a href="{{ route('user.profile') }}" class="btn btn-primary mt-2 ms-2">Apply</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewJobModal{{ $job->id }}" tabindex="-1" aria-labelledby="viewJobModalLabel{{ $job->id }}" aria-hidden="true" data-bs-backdrop="static">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewJobModalLabel{{ $job->id }}">Job Vacancy Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><strong>Job Title:</strong> {{ $job->job_title }}</li>
                                                            <li class="list-group-item"><strong>Position Code:</strong> {{ $job->position_code }}</li>
                                                            <li class="list-group-item"><strong>Division:</strong> {{ $job->division }}</li>
                                                            <li class="list-group-item"><strong>Region:</strong> {{ $job->region }}</li>
                                                            <li class="list-group-item"><strong>Monthly Salary:</strong> {{ $job->monthly_salary }}</li>
                                                            <li class="list-group-item"><strong>Education:</strong> {{ $job->education }}</li>
                                                            <li class="list-group-item"><strong>Training:</strong>
                                                                @if(is_array($job->training) && count($job->training))
                                                                    <ul>
                                                                        @foreach($job->training as $item)
                                                                            <li>{{ $item }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <span>-</span>
                                                                @endif
                                                            </li>
                                                            <li class="list-group-item"><strong>Experience:</strong>
                                                                @if(is_array($job->experience) && count($job->experience))
                                                                    <ul>
                                                                        @foreach($job->experience as $item)
                                                                            <li>{{ $item }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <span>-</span>
                                                                @endif
                                                            </li>
                                                            <li class="list-group-item"><strong>Eligibility:</strong> {{ $job->eligibility }}</li>
                                                            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($job->status) }}</li>
                                                            <li class="list-group-item"><strong>Date Posted:</strong> {{ $job->date_posted }}</li>
                                                            <li class="list-group-item"><strong>Benefits:</strong>
                                                                @if(is_array($job->benefits) && count($job->benefits))
                                                                    <ul>
                                                                        @foreach($job->benefits as $benefit)
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
                                                        <a href="{{ route('user.profile') }}" class="btn btn-primary">Apply</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Start a new row every 2 cards --}}
                                    @if(($index + 1) % 2 == 0 && !$loop->last)
                                        </div><div class="row">
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
               


            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
                    </div>
                    <div class="card-body">
                        second box
                    </div>
                </div>
            </div> -->


        </div>

        
    </div>
</div>
@endsection
