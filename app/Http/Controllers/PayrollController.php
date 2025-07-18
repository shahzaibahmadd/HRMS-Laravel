<?php
namespace App\Http\Controllers;

use App\DTO\PayrollDTO;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
protected $payrollService;

public function __construct(PayrollService $payrollService)
{
$this->payrollService = $payrollService;
}

public function create()
{
$employees = \App\Models\User::role('Employee')->get(); // Spatie role
return view('payroll.create', compact('employees'));
}

public function store(Request $request)
{
$data = $request->validate([
'user_id' => 'required|exists:users,id',
'basic_pay' => 'required|numeric',
'bonuses' => 'nullable|numeric',
'deductions' => 'nullable|numeric',
'pay_date' => 'required|date',
]);

$dto = new PayrollDTO(
user_id: $data['user_id'],
basic_pay: $data['basic_pay'],
bonuses: $data['bonuses'] ?? 0,
deductions: $data['deductions'] ?? 0,
pay_date: $data['pay_date'],
);

$this->payrollService->generatePayroll($dto);

return redirect()->back()->with('success', 'Payroll generated and payslip created.');
}
}

