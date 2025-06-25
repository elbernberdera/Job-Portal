<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LogVisitorIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get visitor IP address
        $ip = $request->ip();
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        $url = $request->path();
        $userAgent = $request->header('User-Agent');
        
        // Detect device type
        $deviceType = $this->getDeviceType($userAgent);
        $browser = $this->getBrowser($userAgent);
        $os = $this->getOperatingSystem($userAgent);
        
        // Check if this is a login attempt
        $isLoginAttempt = $this->isLoginAttempt($url, $request->method());
        
        if ($isLoginAttempt) {
            Log::info("LOGIN ATTEMPT - IP: {$ip} - Device: {$deviceType} - Browser: {$browser} - OS: {$os} - {$timestamp}");
        } else {
            Log::info("Visitor IP: {$ip} - Device: {$deviceType} - Browser: {$browser} - OS: {$os} - {$timestamp}");
        }

        return $next($request);
    }
    
    /**
     * Detect device type from User Agent
     */
    private function getDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent)) {
            if (preg_match('/iPad/i', $userAgent)) {
                return 'Tablet';
            }
            return 'Mobile';
        }
        return 'Desktop';
    }
    
    /**
     * Get browser name from User Agent
     */
    private function getBrowser($userAgent)
    {
        if (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            return 'Edge';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            return 'Opera';
        }
        return 'Unknown';
    }
    
    /**
     * Get operating system from User Agent
     */
    private function getOperatingSystem($userAgent)
    {
        if (preg_match('/Windows/i', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            return 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iOS/i', $userAgent)) {
            return 'iOS';
        }
        return 'Unknown';
    }
    
    /**
     * Check if this is a login attempt
     */
    private function isLoginAttempt($url, $method)
    {
        $loginRoutes = ['login', 'register', 'password/reset', 'password/email'];
        return in_array($url, $loginRoutes) || 
               (str_contains($url, 'login') && $method === 'POST') ||
               (str_contains($url, 'register') && $method === 'POST');
    }
} 