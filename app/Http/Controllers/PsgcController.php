<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PsgcController extends Controller
{
    /**
     * Get all regions.
     */
    public function getRegions()
    {
        // This would typically fetch from a database or external API
        // For now, returning a sample response
        return response()->json([
            'regions' => [
                ['code' => '01', 'name' => 'Ilocos Region'],
                ['code' => '02', 'name' => 'Cagayan Valley'],
                ['code' => '03', 'name' => 'Central Luzon'],
                // Add more regions as needed
            ]
        ]);
    }

    /**
     * Get provinces by region.
     */
    public function getProvinces(Request $request)
    {
        $regionCode = $request->get('region_code');
        
        // This would typically fetch from a database or external API
        // For now, returning a sample response
        return response()->json([
            'provinces' => [
                ['code' => '0128', 'name' => 'Ilocos Norte'],
                ['code' => '0129', 'name' => 'Ilocos Sur'],
                ['code' => '0133', 'name' => 'La Union'],
                ['code' => '0155', 'name' => 'Pangasinan'],
                // Add more provinces as needed
            ]
        ]);
    }

    /**
     * Get cities by province.
     */
    public function getCities(Request $request)
    {
        $provinceCode = $request->get('province_code');
        
        // This would typically fetch from a database or external API
        // For now, returning a sample response
        return response()->json([
            'cities' => [
                ['code' => '012801', 'name' => 'Adams'],
                ['code' => '012802', 'name' => 'Bacarra'],
                ['code' => '012803', 'name' => 'Badoc'],
                // Add more cities as needed
            ]
        ]);
    }

    /**
     * Get barangays by city.
     */
    public function getBarangays(Request $request)
    {
        $cityCode = $request->get('city_code');
        
        // This would typically fetch from a database or external API
        // For now, returning a sample response
        return response()->json([
            'barangays' => [
                ['code' => '012801001', 'name' => 'Adams'],
                ['code' => '012802001', 'name' => 'Bacarra'],
                ['code' => '012803001', 'name' => 'Badoc'],
                // Add more barangays as needed
            ]
        ]);
    }
} 