<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Services\LeaveService;
use App\DTOs\LeaveDTO;

class LeaveController extends Controller
{
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = $this->leaveService->getAllLeaves();
        return response()->json($leaves);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $leaveDTO = LeaveDTO::fromArray($request->all());
        $leave = $this->leaveService->createLeave($leaveDTO);
        return response()->json($leave, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leave = $this->leaveService->getLeaveById($id);
        if (!$leave) {
            return response()->json(["message" => "Leave not found"], 404);
        }
        return response()->json($leave);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $leaveDTO = LeaveDTO::fromArray($request->all());
        $leave = $this->leaveService->updateLeave($id, $leaveDTO);
        if (!$leave) {
            return response()->json(["message" => "Leave not found"], 404);
        }
        return response()->json($leave);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->leaveService->deleteLeave($id)) {
            return response()->json(["message" => "Leave not found"], 404);
        }
        return response()->json(null, 204);
    }

    public function approve(string $id)
    {
        $leave = $this->leaveService->approveLeave($id);
        if (!$leave) {
            return response()->json(["message" => "Leave not found"], 404);
        }
        return response()->json($leave);
    }

    public function reject(string $id)
    {
        $leave = $this->leaveService->rejectLeave($id);
        if (!$leave) {
            return response()->json(["message" => "Leave not found"], 404);
        }
        return response()->json($leave);
    }
}


