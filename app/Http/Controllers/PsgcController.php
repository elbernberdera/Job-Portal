<?php

namespace App\Http\Controllers;

use App\Services\PSGCService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PsgcController extends Controller
{
    protected $psgcService;

    public function __construct(PSGCService $psgcService)
    {
        $this->psgcService = $psgcService;
    }

    /**
     * Get all regions.
     */
    public function getRegions(): JsonResponse
    {
        try {
            $regions = $this->psgcService->getRegions();
            return response()->json([
                'success' => true,
                'regions' => $regions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get provinces by region.
     */
    public function getProvinces(Request $request): JsonResponse
    {
        $request->validate([
            'region_code' => 'required|string'
        ]);

        try {
            $provinces = $this->psgcService->getProvinces($request->region_code);
            return response()->json([
                'success' => true,
                'provinces' => $provinces
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities by province.
     */
    public function getCities(Request $request)
{
    if ($request->has('region_code')) {
        $regionCode = $request->input('region_code');
        // Fetch cities for the region (NCR)
        $response = \Illuminate\Support\Facades\Http::get("https://psgc.gitlab.io/api/regions/{$regionCode}/cities-municipalities/");
        if ($response->successful()) {
            $cities = $response->json();
            return response()->json([
                'success' => true,
                'cities' => $cities
            ]);
        }
        return response()->json(['success' => false, 'cities' => []]);
    }

    if ($request->has('province_code')) {
        $provinceCode = $request->input('province_code');
        $response = \Illuminate\Support\Facades\Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/");
        if ($response->successful()) {
            $cities = $response->json();
            return response()->json([
                'success' => true,
                'cities' => $cities
            ]);
        }
        return response()->json(['success' => false, 'cities' => []]);
    }

    return response()->json(['success' => false, 'cities' => []]);
}
    /**
     * Get barangays by city.
     */
    public function getBarangays(Request $request): JsonResponse
    {
        $request->validate([
            'city_code' => 'required|string'
        ]);

        try {
            $barangays = $this->psgcService->getBarangays($request->city_code);
            return response()->json([
                'success' => true,
                'barangays' => $barangays
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch barangays',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test API connectivity
     */
    public function testConnection(): JsonResponse
    {
        try {
            $isConnected = $this->psgcService->testConnection();
            return response()->json([
                'success' => true,
                'connected' => $isConnected,
                'message' => $isConnected ? 'PSGC API is accessible' : 'PSGC API is not accessible'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'connected' => false,
                'message' => 'Connection test failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear PSGC cache
     */
    public function clearCache(): JsonResponse
    {
        try {
            $this->psgcService->clearCache();
            return response()->json([
                'success' => true,
                'message' => 'PSGC cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 