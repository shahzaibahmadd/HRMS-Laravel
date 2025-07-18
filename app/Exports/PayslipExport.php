<?php
namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromArray;

class PayslipExport implements FromArray
{
    protected $payroll;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function array(): array
    {
        return [
            ['Employee ID', $this->payroll->user_id],
            ['Basic Pay', $this->payroll->basic_pay],
            ['Bonuses', $this->payroll->bonuses],
            ['Deductions', $this->payroll->deductions],
            ['Net Salary', $this->payroll->net_salary],
            ['Pay Date', $this->payroll->pay_date],
        ];
    }
}
