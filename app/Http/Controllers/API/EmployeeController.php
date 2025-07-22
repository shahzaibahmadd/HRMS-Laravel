<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\DTOs\EmployeeDTO;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = $this->employeeService->getAllEmployees();
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employeeDTO = EmployeeDTO::fromArray($request->all());
        $employee = $this->employeeService->createEmployee($employeeDTO);
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = $this->employeeService->getEmployeeById($id);
        if (!$employee) {
            return response()->json(["message" => "Employee not found"], 404);
        }
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employeeDTO = EmployeeDTO::fromArray($request->all());
        $employee = $this->employeeService->updateEmployee($id, $employeeDTO);
        if (!$employee) {
            return response()->json(["message" => "Employee not found"], 404);
        }
        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->employeeService->deleteEmployee($id)) {
            return response()->json(["message" => "Employee not found"], 404);
        }
        return response()->json(null, 204);
    }
}


