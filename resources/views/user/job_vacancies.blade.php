@extends('user.base.base')


<style>
.custom-hover-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s, transform 0.2s;
    background-color: #fff;
}
.custom-hover-card:hover {
    border-color: #007bff;
    background-color: #e6f0ff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.10);
    transform: scale(1.03);
    z-index: 2;
}
</style>

@section('main_content')
@php
function abbreviateJobTitle($title) {
    $map = [
        'information technology' => 'IT',
        'civil engineer' => 'Engr.',
        'business administration' => 'BSBA',
        'Chief Admistratative officer' => 'CAO',
        'Chief Information Officer' => 'CIO',
        'Chief Financial Officer' => 'CFO',
        'Chief Marketing Officer' => 'CMO',
        'Chief Operating Officer' => 'COO',
        'Chief Technology Officer' => 'CTO',
        'Chief Executive Officer' => 'CEO',
        // Add usiness administrationmore mappings as needed
    ];
    foreach ($map as $key => $abbr) {
        if (stripos($title, $key) !== false) {
            return $abbr;
        }
    }
    // Default: return the first letter
    return strtoupper(substr($title, 0, 1));
}
@endphp
<div class="container mt-4  ">
    @forelse($jobs as $job)
        <div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #d1d5db;">
            <div class="row g-0 align-items-center custom-hover-card">
                <div class="col-auto d-flex flex-column align-items-center justify-content-center" style="width: 80px;">
                    <div class="rounded bg-light text-center" style="width: 48px; height: 48px; font-size: 2rem; line-height: 48px; font-weight: bold;">
                        {{ abbreviateJobTitle($job->job_title) }}
                    </div>
                    {{-- Optionally, add a star or featured icon here --}}
                </div>
                <div class="col">
                    <div class="card-body py-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Left: Icon, Job Title, Division, Published -->
                            <div style="flex: 1;">
                                <div class="d-flex align-items-center mb-1">
                                    <div>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <h1 class="card-title mb-1" style="font-weight: bold; font-size: 1.3rem; margin-bottom: 0;">
                                                {{ $job->job_title }}
                                            </h1>
                                           
                                        </div>
                                        <div class="mt-1">
                                        <span class="badge bg-secondary ms-2" style="white-space:nowrap;">
                                                {{ $job->division }}
                                            </span>
                                        </div>
                                        <div class="text-muted small mt-3">
                                            Published: {{ $job->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Center: Region -->
                            <div style="flex: 1; text-align: center;">
                                <span class="text-muted mb-5" style="font-size: 1.1rem;">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $job->region }}
                                </span>
                                <div class="text-muted small mt-3">
                                    Deadline: {{ \Carbon\Carbon::parse($job->closing_date)->format('F d, Y') }}
                                </div>
                            </div>
                            <!-- Right: Badges, Salary, Apply -->
                            <div style="flex: 1; text-align: right;">
                                <div class="mb-3">
                                    <button type="button" class="badge bg-primary me-1 border-0" data-bs-toggle="modal" data-bs-target="#jobDetailsModal{{ $job->id }}">
                                        View Details
                                    </button>
                                    <span class="badge bg-success">Full Time</span>
                                </div>
                                <div class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                    ₱{{ number_format($job->monthly_salary, 2) }} /monthly
                                </div>
                                <a href="{{ route('user.apply_for_job', ['job' => $job->id]) }}" class="btn btn-link p-0">
                                    Apply Now &raquo;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="jobDetailsModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobDetailsModalLabel{{ $job->id }}" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="jobDetailsModalLabel{{ $job->id }}">{{ $job->job_title }} Details</h5>
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
                                </div>
            </div>
          </div>
        </div>

        @if(session('show_apply_modal') && session('job_id') == $job->id)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = new bootstrap.Modal(document.getElementById('applyModal-{{ $job->id }}'));
                    modal.show();
                });
            </script>
        @endif
        <!-- Modal HTML -->
        <div class="modal fade" id="applyModal-{{ $job->id }}" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Proceed to Apply?</h5>
              </div>
              <div class="modal-body">
                <p>Your profile is complete. Do you want to proceed with your application or update your profile?</p>
              </div>
              <div class="modal-footer">
                <a href="{{ route('user.pds.form', ['job' => $job->id]) }}" class="btn btn-secondary">Update Profile</a>
                <a href="#" class="btn btn-primary proceed-btn" data-job-title="{{ $job->job_title }}">Proceed</a>
                
              </div>
            </div>
          </div>
        </div>
    @empty
        <div class="alert alert-info">No job vacancies available at the moment.</div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.proceed-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const jobTitle = this.getAttribute('data-job-title');
            Swal.fire({
                icon: 'success',
                title: 'Congratulations!',
                html: `You have been applied for this job: <b>${jobTitle}</b>`,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('user.dashboard') }}";
            });
        });
    });
});
</script>
@endsection 