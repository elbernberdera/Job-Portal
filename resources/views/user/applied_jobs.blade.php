@extends('user.base.base')

@section('main_content')


  <!-- User Calendar Table -->
  <div class="container py-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">My Applied Jobs</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                <th><strong>Job Title</strong></th>
                            <th><strong>Date Applied</strong></th>
                            <th><strong>Status</strong></th>




                                </tr>
                            </thead>
                            <tbody>
                            @forelse($appliedJobs as $index => $application)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($application->jobVacancy)
                                        {{ $application->jobVacancy->job_title }}
                                    @else
                                        <span class="text-danger">Job not found (ID: {{ $application->job_vacancy_id }})</span>
                                    @endif
                                </td>
                                <td>{{ $application->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'applied' => 'secondary',
                                            'under_review' => 'info',
                                            'shortlisted' => 'primary',
                                            'interviewed' => 'warning',
                                            'offered' => 'success',
                                            'hired' => 'success',
                                            'rejected' => 'danger',
                                            'failed' => 'dark',
                                        ];
                                        $status = $application->status ?? 'applied';
                                        $color = $statusColors[$status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No jobs found.</td>
                            </tr>
                        @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




@endsection 