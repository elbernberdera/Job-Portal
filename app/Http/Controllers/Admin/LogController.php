<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Exports\ActivityLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::orderByDesc('created_at')->paginate(10);
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

    /**
     * Filter logs by selected date
     */
    public function filterByDate(Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date'
        ]);

        $selectedDate = Carbon::parse($request->selected_date)->format('Y-m-d');
        
        $logs = ActivityLog::whereDate('created_at', $selectedDate)
            ->orWhereDate('login_at', $selectedDate)
            ->orWhereDate('logout_at', $selectedDate)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.logs', compact('logs', 'selectedDate'));
    }

    /**
     * Get logs for AJAX request by date
     */
    public function ajaxLogsByDate(Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date'
        ]);

        $selectedDate = Carbon::parse($request->selected_date)->format('Y-m-d');
        
        $logs = ActivityLog::whereDate('created_at', $selectedDate)
            ->orWhereDate('login_at', $selectedDate)
            ->orWhereDate('logout_at', $selectedDate)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.partials.logs_table', compact('logs'))->render();
    }

    /**
     * Export logs for specific date
     */
    public function exportByDate(Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date'
        ]);

        $selectedDate = Carbon::parse($request->selected_date)->format('Y-m-d');
        
        $filename = 'activity_logs_' . $selectedDate . '.xlsx';
        
        // Create a custom export class for date-specific logs
        $export = new class($selectedDate) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping, \Maatwebsite\Excel\Concerns\ShouldAutoSize, \Maatwebsite\Excel\Concerns\WithStyles {
            private $date;
            
            public function __construct($date) {
                $this->date = $date;
            }
            
            public function collection()
            {
                return \App\Models\ActivityLog::whereDate('created_at', $this->date)
                    ->orWhereDate('login_at', $this->date)
                    ->orWhereDate('logout_at', $this->date)
                    ->orderByDesc('created_at')
                    ->get();
            }
            
            public function headings(): array
            {
                return [
                    'User Name',
                    'Email',
                    'IP Address',
                    'Device',
                    'Login Time',
                    'Logout Time',
                    'Role',
                    'Activity',
                    'Created At',
                ];
            }
            
            public function map($log): array
            {
                $role = match($log->role) {
                    1 => 'Admin',
                    2 => 'HR',
                    3 => 'User',
                    default => '-'
                };

                return [
                    $log->user_name,
                    $log->email,
                    $log->ip_address,
                    $log->device,
                    $log->login_at ? Carbon::parse($log->login_at)->format('Y-m-d H:i:s') : '',
                    $log->logout_at ? Carbon::parse($log->logout_at)->format('Y-m-d H:i:s') : '',
                    $role,
                    $log->activity ?? '-',
                    Carbon::parse($log->created_at)->format('Y-m-d H:i:s'),
                ];
            }
            
            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [
                    1 => [
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'E2E8F0']
                        ]
                    ],
                ];
            }
        };
        
        return Excel::download($export, $filename);
    }
} 