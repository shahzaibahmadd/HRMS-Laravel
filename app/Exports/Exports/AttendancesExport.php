<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::with('employee')->get();
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
            'Check In Time',
            'Check Out Time',
            'Duration (Hours)',
            'Date',
            'Created At'
        ];
    }

    /**
     * @param Attendance $attendance
     * @return array
     */
    public function map($attendance): array
    {
        $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
        $checkOut = $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time) : null;
        $duration = $checkOut ? $checkOut->diffInHours($checkIn, true) : null;

        return [
            $attendance->id,
            $attendance->employee ? $attendance->employee->first_name . ' ' . $attendance->employee->last_name : 'N/A',
            $attendance->employee ? $attendance->employee->email : 'N/A',
            $attendance->check_in_time,
            $attendance->check_out_time,
            $duration ? round($duration, 2) : 'In Progress',
            $checkIn->format('Y-m-d'),
            $attendance->created_at,
        ];
    }
}

