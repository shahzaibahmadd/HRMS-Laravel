<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendancem;
use Illuminate\Http\Request;
use App\Services\AttendanceService;
use App\DTOs\AttendanceDTO;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = $this->attendanceService->getAllAttendances();
        return response()->json($attendances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attendanceDTO = AttendanceDTO::fromArray($request->all());
        $attendance = $this->attendanceService->createAttendance($attendanceDTO);
        return response()->json($attendance, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = $this->attendanceService->getAttendanceById($id);
        if (!$attendance) {
            return response()->json(["message" => "Attendance not found"], 404);
        }
        return response()->json($attendance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendanceDTO = AttendanceDTO::fromArray($request->all());
        $attendance = $this->attendanceService->updateAttendance($id, $attendanceDTO);
        if (!$attendance) {
            return response()->json(["message" => "Attendance not found"], 404);
        }
        return response()->json($attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->attendanceService->deleteAttendance($id)) {
            return response()->json(["message" => "Attendance not found"], 404);
        }
        return response()->json(null, 204);
    }

    public function checkIn(Request $request)
    {
        $employeeId = $request->input("employee_id");
        $attendance = $this->attendanceService->checkIn($employeeId);
        return response()->json($attendance, 201);
    }

    public function checkOut(Request $request, string $id)
    {
        $attendance = $this->attendanceService->checkOut($id);
        if (!$attendance) {
            return response()->json(["message" => "Attendance not found"], 404);
        }
        return response()->json($attendance);
    }
}


