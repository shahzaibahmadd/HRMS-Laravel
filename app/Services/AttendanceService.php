<?php

namespace App\Services;

use App\DTOs\AttendanceDTO;
use App\Models\Attendancem;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService
{
    public function getAllAttendances(): Collection
    {
        return Attendancem::with("employee")->get();
    }

    public function getAttendanceById(int $id): ?Attendancem
    {
        return Attendancem::with("employee")->find($id);
    }

    public function getAttendancesByEmployee(int $employeeId): Collection
    {
        return Attendancem::where("employee_id", $employeeId)->get();
    }

    public function createAttendance(AttendanceDTO $attendanceDTO): Attendancem
    {
        return Attendancem::create($attendanceDTO->toArray());
    }

    public function updateAttendance(int $id, AttendanceDTO $attendanceDTO): ?Attendancem
    {
        $attendance = Attendancem::find($id);

        if (!$attendance) {
            return null;
        }

        $attendance->update($attendanceDTO->toArray());

        return $attendance;
    }

    public function deleteAttendance(int $id): bool
    {
        $attendance = Attendancem::find($id);

        if (!$attendance) {
            return false;
        }

        return $attendance->delete();
    }

    public function checkIn(int $employeeId): Attendancem
    {
        $attendanceDTO = AttendanceDTO::fromArray([
            "employee_id" => $employeeId,
            "check_in_time" => now(),
        ]);

        return $this->createAttendance($attendanceDTO);
    }

    public function checkOut(int $attendanceId): ?Attendancem
    {
        $attendance = Attendancem::find($attendanceId);

        if (!$attendance) {
            return null;
        }

        $attendanceDTO = AttendanceDTO::fromArray([
            "check_out_time" => now(),
        ]);

        return $this->updateAttendance($attendanceId, $attendanceDTO);
    }
}

