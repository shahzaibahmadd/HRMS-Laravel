<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeavesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Leave::with('employee')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Employee Name',
            'Employee Email',
            'Leave Type',
            'Start Date',
            'End Date',
            'Days',
            'Reason',
            'Status',
            'Created At'
        ];
    }

    /**
     * @param Leave $leave
     * @return array
     */
    public function map($leave): array
    {
        $startDate = \Carbon\Carbon::parse($leave->start_date);
        $endDate = \Carbon\Carbon::parse($leave->end_date);
        $days = $endDate->diffInDays($startDate) + 1;

        return [
            $leave->id,
            $leave->employee ? $leave->employee->first_name . ' ' . $leave->employee->last_name : 'N/A',
            $leave->employee ? $leave->employee->email : 'N/A',
            $leave->leave_type,
            $leave->start_date,
            $leave->end_date,
            $days,
            $leave->reason,
            ucfirst($leave->status),
            $leave->created_at,
        ];
    }
}

