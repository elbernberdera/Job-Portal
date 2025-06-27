<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ActivityLogsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLog::orderByDesc('created_at')->get();
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

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}
