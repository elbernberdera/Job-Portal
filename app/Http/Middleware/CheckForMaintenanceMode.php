<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckForMaintenanceMode
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
        if (Setting::get('maintenance_mode', false)) {
            // 1. If logged in and admin, allow all access
            if (Auth::check() && Auth::user()->role === 1) {
                return $next($request);
            }

            // 2. Allow access to landing, login, register, and logout pages
            if ($request->is('/') || $request->is('login') || $request->is('register') || $request->is('logout')) {
                return $next($request);
            }

            // 3. If logged in but not admin, log out and show maintenance page
            if (Auth::check() && Auth::user()->role !== 1) {
                Auth::logout();
                return response()->view('maintenance');
            }

            // 4. All others see maintenance page
            return response()->view('maintenance');
        }

        return $next($request);
    }
}
