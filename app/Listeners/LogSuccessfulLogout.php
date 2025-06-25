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

        // Find the latest login log for this user without a logout time
        $log = ActivityLog::where('user_id', $user->id)
            ->whereNull('logout_at')
            ->orderByDesc('login_at')
            ->first();

        if ($log) {
            $log->logout_at = now(); // Asia/Manila
            $log->save();
        }
    }
} 