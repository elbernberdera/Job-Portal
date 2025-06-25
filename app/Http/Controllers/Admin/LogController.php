<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderByDesc('login_at')->get();
        return view('admin.logs', compact('logs'));
    }
} 