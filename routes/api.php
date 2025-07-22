<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\LeaveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Employee API Routes
Route::apiResource('employees', EmployeeController::class);

// Attendance API Routes
Route::apiResource('attendances', AttendanceController::class);
Route::post('attendances/check-in', [AttendanceController::class, 'checkIn']);
Route::patch('attendances/{id}/check-out', [AttendanceController::class, 'checkOut']);

// Leave API Routes
Route::apiResource('leaves', LeaveController::class);
Route::patch('leaves/{id}/approve', [LeaveController::class, 'approve']);
Route::patch('leaves/{id}/reject', [LeaveController::class, 'reject']);

