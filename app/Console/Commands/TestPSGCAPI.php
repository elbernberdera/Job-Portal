<?php

namespace App\Console\Commands;

use App\Services\PSGCService;
use Illuminate\Console\Command;

class TestPSGCAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psgc:test {--cache : Test cache functionality} {--full : Test complete data loading}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PSGC API connectivity and functionality';

    protected $psgcService;

    public function __construct(PSGCService $psgcService)
    {
        parent::__construct();
        $this->psgcService = $psgcService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PSGC API Integration...');
        $this->newLine();

        // Test basic connectivity
        $this->testConnection();

        if ($this->option('cache')) {
            $this->testCache();
        }

        if ($this->option('full')) {
            $this->testFullData();
        }

        $this->info('PSGC API test completed!');
    }

    private function testConnection()
    {
        $this->info('1. Testing API Connection...');
        
        try {
            $isConnected = $this->psgcService->testConnection();
            
            if ($isConnected) {
                $this->info('   ✓ API is accessible');
            } else {
                $this->error('   ✗ API is not accessible');
                return false;
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Connection failed: ' . $e->getMessage());
            return false;
        }

        $this->newLine();
        return true;
    }

    private function testCache()
    {
        $this->info('2. Testing Cache Functionality...');

        try {
            // Test regions cache
            $this->info('   Testing regions cache...');
            $regions = $this->psgcService->getRegions();
            $this->info("   ✓ Loaded " . count($regions) . " regions");

            // Test provinces cache for first region
            if (!empty($regions)) {
                $firstRegion = $regions[0];
                $this->info("   Testing provinces cache for {$firstRegion['name']}...");
                $provinces = $this->psgcService->getProvinces($firstRegion['code']);
                $this->info("   ✓ Loaded " . count($provinces) . " provinces");

                // Test cities cache for first province
                if (!empty($provinces)) {
                    $firstProvince = $provinces[0];
                    $this->info("   Testing cities cache for {$firstProvince['name']}...");
                    $cities = $this->psgcService->getCities($firstProvince['code']);
                    $this->info("   ✓ Loaded " . count($cities) . " cities");

                    // Test barangays cache for first city
                    if (!empty($cities)) {
                        $firstCity = $cities[0];
                        $this->info("   Testing barangays cache for {$firstCity['name']}...");
                        $barangays = $this->psgcService->getBarangays($firstCity['code']);
                        $this->info("   ✓ Loaded " . count($barangays) . " barangays");
                    }
                }
            }

            $this->info('   ✓ Cache functionality working correctly');
        } catch (\Exception $e) {
            $this->error('   ✗ Cache test failed: ' . $e->getMessage());
        }

        $this->newLine();
    }

    private function testFullData()
    {
        $this->info('3. Testing Complete Data Loading...');

        try {
            $this->info('   Loading complete address data (this may take a while)...');
            $addressData = $this->psgcService->getAddressData();
            
            $regionCount = count($addressData);
            $provinceCount = 0;
            $cityCount = 0;
            $barangayCount = 0;

            foreach ($addressData as $region) {
                $provinceCount += count($region['provinces']);
                foreach ($region['provinces'] as $province) {
                    $cityCount += count($province['cities']);
                    foreach ($province['cities'] as $city) {
                        $barangayCount += count($city['barangays']);
                    }
                }
            }

            $this->info("   ✓ Complete data loaded successfully:");
            $this->info("     - Regions: {$regionCount}");
            $this->info("     - Provinces: {$provinceCount}");
            $this->info("     - Cities/Municipalities: {$cityCount}");
            $this->info("     - Barangays: {$barangayCount}");

        } catch (\Exception $e) {
            $this->error('   ✗ Full data test failed: ' . $e->getMessage());
        }

        $this->newLine();
    }
} 