<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ActivityLog;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        \Log::info('LogSuccessfulLogin listener fired for user: ' . $user->email);
        $request = request();
        
        $ip = $request->ip();
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        $userAgent = $request->header('User-Agent');
        
        // Detect device information
        $deviceType = $this->getDeviceType($userAgent);
        $browser = $this->getBrowser($userAgent);
        $os = $this->getOperatingSystem($userAgent);
        
        Log::info("SUCCESSFUL LOGIN - User: {$user->email} - IP: {$ip} - Device: {$deviceType} - Browser: {$browser} - OS: {$os} - {$timestamp}");
        
        // Always create a new log entry for login (like logout)
        try {
            $logEntry = ActivityLog::create([
                'user_id'   => $user->id,
                'user_name' => ($user->first_name ?? '') . ' ' . ($user->last_name ?? ''),
                'email'     => $user->email,
                'ip_address'=> $ip,
                'device'    => $deviceType,
                'login_at'  => now(),
                'role'      => $user->role,
                'activity'  => 'logged in',
            ]);
            \Log::info('Login log entry created successfully with ID: ' . $logEntry->id);
        } catch (\Exception $e) {
            \Log::error('Failed to create login log entry: ' . $e->getMessage());
        }
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
} 