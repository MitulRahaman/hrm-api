<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use App\Http\Requests\ClockOutRequest;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    private $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    public function clockIn(ClockInRequest $request)
    {
        $data = $this->attendanceService->clockIn($request->validated());
        if ($data) {
            return response()->json([
                'status' => 'true',
                'error' => 'null',
                'data' => $data,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'false',
                'error' => 'no data',
                'data' => $data,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function clockOut(ClockOutRequest $request)
    {
        $data = $this->attendanceService->clockOut($request->all());
        if ($data) {
            return response()->json([
                'status' => 'true',
                'error' => 'null',
                'data' => $data,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'false',
                'error' => 'no data',
                'data' => null,
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
