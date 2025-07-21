<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;

use App\Models\Payroll;
use App\Models\Payslip;
use Illuminate\Support\Facades\Storage;
use App\Exports\PayslipExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class PayslipController extends Controller
{
    public function generate(Payroll $payroll)
    {
        try {
            $fileName = 'payslip_' . $payroll->id . '_' . now()->format('YmdHis') . '.xlsx';
            $filePath = 'payslips/' . $fileName;


            Excel::store(new PayslipExport($payroll), $filePath, 'public');



            if ($payroll->payslip) {
                Storage::delete($payroll->payslip->file_path);
                $payroll->payslip->delete();
            }

            // Save new payslip record
            Payslip::create([
                'payroll_id' => $payroll->id,
                'file_path' => $filePath
            ]);

            return back()->with('message', 'Payslip generated successfully!');
        } catch (\Throwable $e) {
            \App\Services\ErrorLoggingService::log($e);
            return back()->with('message', 'Failed to generate payslip.');
        }
    }

    public function download(Payslip $payslip)
    {
        if (!Storage::disk('public')->exists($payslip->file_path)) {
            return back()->with('message', 'Payslip file not found.');
        }

        return Storage::disk('public')->download($payslip->file_path);
    }

}
