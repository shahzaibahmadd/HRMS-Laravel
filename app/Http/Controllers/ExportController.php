<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use App\Exports\AttendancesExport;
use App\Exports\LeavesExport;

class ExportController extends Controller
{
    public function exportEmployees()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }

    public function exportAttendances()
    {
        return Excel::download(new AttendancesExport, 'attendances.xlsx');
    }

    public function exportLeaves()
    {
        return Excel::download(new LeavesExport, 'leaves.xlsx');
    }
}

