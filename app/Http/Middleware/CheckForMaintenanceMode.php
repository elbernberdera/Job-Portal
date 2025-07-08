<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $maintenance = Setting::getValue('maintenance_mode', false);
        $isAdmin = Auth::check() && Auth::user()->role == 1;

        if ($maintenance && !$isAdmin) {
            // If not admin, show maintenance page
            return response()->view('maintenance');
        }

        return $next($request);
    }
}
