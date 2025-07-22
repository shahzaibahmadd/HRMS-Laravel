<?php

namespace App\Services;

use App\DTOs\LeaveDTO;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Collection;

class LeaveService
{
    public function getAllLeaves(): Collection
    {
        return Leave::with("employee")->get();
    }

    public function getLeaveById(int $id): ?Leave
    {
        return Leave::with("employee")->find($id);
    }

    public function getLeavesByEmployee(int $employeeId): Collection
    {
        return Leave::where("employee_id", $employeeId)->get();
    }

    public function createLeave(LeaveDTO $leaveDTO): Leave
    {
        return Leave::create($leaveDTO->toArray());
    }

    public function updateLeave(int $id, LeaveDTO $leaveDTO): ?Leave
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return null;
        }

        $leave->update($leaveDTO->toArray());

        return $leave;
    }

    public function deleteLeave(int $id): bool
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return false;
        }

        return $leave->delete();
    }

    public function approveLeave(int $id): ?Leave
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return null;
        }

        $leaveDTO = LeaveDTO::fromArray([
            "status" => "approved",
        ]);

        return $this->updateLeave($id, $leaveDTO);
    }

    public function rejectLeave(int $id): ?Leave
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return null;
        }

        $leaveDTO = LeaveDTO::fromArray([
            "status" => "rejected",
        ]);

        return $this->updateLeave($id, $leaveDTO);
    }

    public function getPendingLeaves(): Collection
    {
        return Leave::with("employee")->where("status", "pending")->get();
    }
}

