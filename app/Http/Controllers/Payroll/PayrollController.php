<?php

namespace App\Http\Controllers\Payroll;

use App\DTOs\Payroll\CreatePayrollDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\payroll\CreatePayrollRequest;
use App\Models\Payroll;
use App\Services\ErrorLoggingService;
use App\Services\Payroll\PayrollService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayslipExport;


class PayrollController extends Controller
{
    public function __construct(
        protected PayrollService $payrollService,
        protected ErrorLoggingService $errorLoggingService
    ) {}

    public function store(CreatePayrollRequest $request)
    {
        try {
            DB::beginTransaction();

            $dto = new CreatePayrollDTO($request);
            $payroll = $this->payrollService->create($dto);

            DB::commit();

            return response()->json(['message' => 'Payroll created successfully', 'data' => $payroll], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->errorLoggingService->log($e, 'payroll-store');
            return response()->json(['message' => 'Payroll creation failed'], 500);
        }
    }


    public function edit(User $user)
    {

        $role = auth()->user()->getRoleNames()->first();

        if ($role === 'Manager' && $user->hasRole('Manager')) {
            abort(403);
        }

        if ($role === 'HR' && $user->hasRole('Admin')) {
            abort(403);
        }

        $payroll = $user->payroll ?? new Payroll();
        return view('payroll.edit', compact('user', 'payroll'));
    }


    public function update(Request $request, User $user)
    {
        $role = auth()->user()->getRoleNames()->first();

        if ($role === 'Manager' && $user->hasRole('Manager')) {
            abort(403);
        }

        if ($role === 'HR' && $user->hasRole('Admin')) {
            abort(403);
        }

        $request->validate([
            'basic_pay' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'pay_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $dto = new CreatePayrollDTO($request);
            $dto->user_id = $user->id;

            $payroll = $user->payroll ?? new Payroll(['user_id' => $user->id]);
            $payroll->fill($dto->toArray())->save();

            DB::commit();

            return redirect()->back()->with('success', 'Payroll updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->errorLoggingService->log($e, 'payroll-update');
            return redirect()->back()->with('error', 'Payroll update failed.');
        }
    }



    public function show(User $user)
    {
        try {
            $currentUser = Auth::user();

            if (
                ($currentUser->hasPermissionTo('view all payrolls')) ||  // Admin
                ($currentUser->hasPermissionTo('view hr and manager payrolls') &&
                    ($user->hasRole('HR') || $user->hasRole('Manager'))) || // HR
                ($currentUser->hasPermissionTo('view employee payrolls') &&
                    $user->hasRole('HR') || $user->hasRole('Employee') || $user->hasRole('Manager')) || // Manager
                ($currentUser->hasPermissionTo('view own payroll') &&
                    $currentUser->id === $user->id)

            ) {
                $payroll = $user->payroll;

                if (!$payroll) {
                    return view('payroll.show', compact('user'))->with('message', 'No payroll record found.');
                }

                return view('payroll.show', compact('user', 'payroll'));
            }

            abort(403, 'Unauthorized to view this payroll');
        } catch (\Throwable $e) {
            $this->errorLoggingService->log($e, 'payroll-show');
            return back()->with('error', 'Something went wrong.');
        }
    }






}
