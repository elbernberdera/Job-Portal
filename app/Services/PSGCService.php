<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PSGCService
{
    private const BASE_URL = 'https://psgc.gitlab.io/api';
    private const CACHE_TTL = 86400; // 24 hours

    /**
     * Get all regions
     */
    public function getRegions()
    {
        return Cache::remember('psgc_regions', self::CACHE_TTL, function () {
            try {
                $response = Http::timeout(30)->get(self::BASE_URL . '/regions');
                return $response->successful() ? $response->json() : [];
            } catch (\Exception $e) {
                Log::error('PSGC API Error - Regions: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get provinces by region code
     */
    public function getProvinces($regionCode)
    {
        $cacheKey = "psgc_provinces_{$regionCode}";
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($regionCode) {
            try {
                $response = Http::timeout(30)->get(self::BASE_URL . "/regions/{$regionCode}/provinces");
                return $response->successful() ? $response->json() : [];
            } catch (\Exception $e) {
                Log::error("PSGC API Error - Provinces for region {$regionCode}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get cities/municipalities by province code
     */
    public function getCities($provinceCode)
    {
        $cacheKey = "psgc_cities_{$provinceCode}";
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($provinceCode) {
            try {
                $response = Http::timeout(30)->get(self::BASE_URL . "/provinces/{$provinceCode}/cities-municipalities");
                return $response->successful() ? $response->json() : [];
            } catch (\Exception $e) {
                Log::error("PSGC API Error - Cities for province {$provinceCode}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get barangays by city/municipality code
     */
    public function getBarangays($cityCode)
    {
        $cacheKey = "psgc_barangays_{$cityCode}";
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($cityCode) {
            try {
                $response = Http::timeout(30)->get(self::BASE_URL . "/cities-municipalities/{$cityCode}/barangays");
                return $response->successful() ? $response->json() : [];
            } catch (\Exception $e) {
                Log::error("PSGC API Error - Barangays for city {$cityCode}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get complete address data for dropdowns
     */
    public function getAddressData()
    {
        return Cache::remember('psgc_complete_address', self::CACHE_TTL, function () {
            $regions = $this->getRegions();
            $addressData = [];

            foreach ($regions as $region) {
                $regionData = [
                    'name' => $region['name'],
                    'code' => $region['code'],
                    'provinces' => []
                ];

                $provinces = $this->getProvinces($region['code']);
                foreach ($provinces as $province) {
                    $provinceData = [
                        'name' => $province['name'],
                        'code' => $province['code'],
                        'cities' => []
                    ];

                    $cities = $this->getCities($province['code']);
                    foreach ($cities as $city) {
                        $cityData = [
                            'name' => $city['name'],
                            'code' => $city['code'],
                            'barangays' => []
                        ];

                        $barangays = $this->getBarangays($city['code']);
                        foreach ($barangays as $barangay) {
                            $cityData['barangays'][] = $barangay['name'];
                        }

                        $provinceData['cities'][] = $cityData;
                    }

                    $regionData['provinces'][] = $provinceData;
                }

                $addressData[] = $regionData;
            }

            return $addressData;
        });
    }

    /**
     * Clear all PSGC cache
     */
    public function clearCache()
    {
        Cache::forget('psgc_regions');
        Cache::forget('psgc_complete_address');
        
        // Clear province caches
        $regions = $this->getRegions();
        foreach ($regions as $region) {
            Cache::forget("psgc_provinces_{$region['code']}");
            
            $provinces = $this->getProvinces($region['code']);
            foreach ($provinces as $province) {
                Cache::forget("psgc_cities_{$province['code']}");
                
                $cities = $this->getCities($province['code']);
                foreach ($cities as $city) {
                    Cache::forget("psgc_barangays_{$city['code']}");
                }
            }
        }
    }

    /**
     * Test API connectivity
     */
    public function testConnection()
    {
        try {
            $response = Http::timeout(10)->get(self::BASE_URL . '/regions');
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('PSGC API Connection Test Failed: ' . $e->getMessage());
            return false;
        }
    }
} 