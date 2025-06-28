@extends('user.base.base')

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
<div class="container mt-4">
    @forelse($jobs as $job)
        <div class="card mb-3 shadow-sm" style="border-radius: 12px; border: 1px solid #d1d5db;">
            <div class="row g-0 align-items-center">
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
                                    Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}
                                </div>
                            </div>
                            <!-- Right: Badges, Salary, Apply -->
                            <div style="flex: 1; text-align: right;">
                                <div class="mb-3">
                                    <span class="badge bg-primary me-1">FEATURED</span>
                                    <span class="badge bg-danger">Full Time</span>
                                </div>
                                <div class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                    ₱{{ number_format($job->monthly_salary, 2) }} /monthly
                                </div>
                                <a href="{{ route('user.job.apply', $job->id) }}" class="btn btn-link p-0">Apply Now &raquo;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No job vacancies available at the moment.</div>
    @endforelse
</div>
@endsection 