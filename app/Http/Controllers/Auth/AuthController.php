<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authentication(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:users,employee_id',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $validator->errors()->first(),
                    'data' => null,
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
            $userExist = $this->authService->authenticate($request);
            if ($userExist) {
                return response()->json([
                    'status' => 'true',
                    'error' => 'null',
                    'data' => $userExist,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => 'false',
                    'error' => 'password mismatch',
                    'user' => null,
                ], Response::HTTP_UNAUTHORIZED);
            }

        } catch (\Exception $exception) {
            return response(['success' => false, 'error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
