<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        if (!$user) return;
        \Log::info('LogSuccessfulLogout listener fired for user: ' . $user->email);

        // Always create a new log entry for logout
        try {
            $logEntry = \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => ($user->first_name ?? '') . ' ' . ($user->last_name ?? ''),
                'email' => $user->email,
                'ip_address' => request()->ip(),
                'device' => request()->header('User-Agent'),
                'logout_at' => now(),
                'role' => $user->role,
                'activity' => 'logged out',
            ]);
            \Log::info('Logout log entry created successfully with ID: ' . $logEntry->id);
        } catch (\Exception $e) {
            \Log::error('Failed to create logout log entry: ' . $e->getMessage());
        }
    }
} 