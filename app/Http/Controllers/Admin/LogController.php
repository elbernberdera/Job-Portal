<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Exports\ActivityLogsExport;
use Maatwebsite\Excel\Facades\Excel;

class LogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::orderByDesc('created_at')->get();
        return view('admin.logs', compact('logs'));
    }

    public function ajaxLogs()
    {
        $logs = \App\Models\ActivityLog::orderByDesc('created_at')->get();
        return view('admin.partials.logs_table', compact('logs'))->render();
    }

    public function export()
    {
        $filename = 'activity_logs_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new ActivityLogsExport, $filename);
    }
} 