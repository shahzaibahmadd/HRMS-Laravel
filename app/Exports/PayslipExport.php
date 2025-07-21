<?php
namespace App\Exports;

use App\Models\Payroll;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayslipExport implements FromView
{
    protected $payroll;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function view(): View
    {
        return view('exports.payslip', [
            'payroll' => $this->payroll,
            'user' => $this->payroll->user,
            'payslip' => $this->payroll->payslip
        ]);
    }
}
