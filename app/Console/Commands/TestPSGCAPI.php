<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PSGCService;

class TestPSGCAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psgc:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PSGC API connectivity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PSGC API...');

        try {
            $service = new PSGCService();
            
            $this->info('Testing connection...');
            $connected = $service->testConnection();
            $this->info('Connected: ' . ($connected ? 'YES' : 'NO'));
            
            if ($connected) {
                $this->info('Fetching regions...');
                $regions = $service->getRegions();
                $this->info('Regions count: ' . count($regions));
                
                if (count($regions) > 0) {
                    $this->info('First region: ' . $regions[0]['name']);
                    
                    // Test provinces for first region
                    $this->info('Testing provinces for first region...');
                    $provinces = $service->getProvinces($regions[0]['code']);
                    $this->info('Provinces count: ' . count($provinces));
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
} 