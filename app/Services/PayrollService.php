<?php

namespace App\Services;

use App\DTO\PayrollDTO;
use App\Models\Payroll;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayslipExport;

class PayrollService
{
    public function generatePayroll(PayrollDTO $dto): Payroll
    {
        return DB::transaction(function () use ($dto) {
            $payroll = Payroll::create($dto->toArray());

            // File name and path
            $fileName = "payslip_{$payroll->id}.xlsx";
            $filePath = "payslips/{$fileName}";
            // Generate and export payslip
            Excel::store(new PayslipExport($payroll), "payslips/payroll_{$payroll->id}.xlsx", 'public');
            Payslip::create([
                'payroll_id' => $payroll->id,
                'file_path' => $filePath,
            ]);
            return $payroll;
        });
    }
}
