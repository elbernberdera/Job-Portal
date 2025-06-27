<?php

namespace App\Http\Controllers;

use App\Services\PSGCService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    protected $psgcService;

    public function __construct(PSGCService $psgcService)
    {
        $this->psgcService = $psgcService;
    }

    /**
     * Get all regions
     */
    public function getRegions(): JsonResponse
    {
        try {
            $regions = $this->psgcService->getRegions();
            return response()->json([
                'success' => true,
                'data' => $regions
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
     * Get provinces by region
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
                'data' => $provinces
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
     * Get cities/municipalities by province
     */
    public function getCities(Request $request): JsonResponse
    {
        $request->validate([
            'province_code' => 'required|string'
        ]);

        try {
            $cities = $this->psgcService->getCities($request->province_code);
            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get barangays by city/municipality
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
                'data' => $barangays
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
     * Get complete address data for dropdowns
     */
    public function getAddressData(): JsonResponse
    {
        try {
            $addressData = $this->psgcService->getAddressData();
            return response()->json([
                'success' => true,
                'data' => $addressData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch address data',
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