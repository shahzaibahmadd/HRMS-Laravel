<?php

namespace App\Services;

use App\DTOs\EmployeeDTO;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
    public function getAllEmployees(): Collection
    {
        return Employee::all();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function createEmployee(EmployeeDTO $employeeDTO): Employee
    {
        $data = $employeeDTO->toArray();

        if (isset($data["profile_picture"])) {
            $data["profile_picture"] = Storage::putFile("public/profile_pictures", $data["profile_picture"]);
        }

        return Employee::create($data);
    }

    public function updateEmployee(int $id, EmployeeDTO $employeeDTO): ?Employee
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return null;
        }

        $data = $employeeDTO->toArray();

        if (isset($data["profile_picture"])) {
            if ($employee->profile_picture) {
                Storage::delete($employee->profile_picture);
            }
            $data["profile_picture"] = Storage::putFile("public/profile_pictures", $data["profile_picture"]);
        }

        $employee->update($data);

        return $employee;
    }

    public function deleteEmployee(int $id): bool
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return false;
        }

        if ($employee->profile_picture) {
            Storage::delete($employee->profile_picture);
        }

        return $employee->delete();
    }

    public function restoreEmployee(int $id): bool
    {
        $employee = Employee::withTrashed()->find($id);

        if (!$employee) {
            return false;
        }

        return $employee->restore();
    }
}


