<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobVacancy;
use Carbon\Carbon;

class ArchiveExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:archive-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive job vacancies that have passed their closing date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to archive expired job vacancies...');

        // Get all open jobs that have passed their closing date
        $expiredJobs = JobVacancy::where('status', 'open')
            ->whereNotNull('closing_date')
            ->where('closing_date', '<', Carbon::today())
            ->get();

        $count = $expiredJobs->count();

        if ($count === 0) {
            $this->info('No expired jobs found to archive.');
            return 0;
        }

        $this->info("Found {$count} expired job(s) to archive.");

        foreach ($expiredJobs as $job) {
            $job->status = 'archived';
            $job->save();
            
            $this->line("Archived: {$job->job_title} (ID: {$job->id}) - Closed on: {$job->closing_date}");
        }

        $this->info("Successfully archived {$count} job vacancy(ies).");
        return 0;
    }
}
