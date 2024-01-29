<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function authenticate($request)
    {
        try {
            $this->authRepository->setEmployeeId($request['employee_id']);
            $userExist = $this->authRepository->userExist();
            $getUserInfo = $this->authRepository->getUserInfo($userExist->id);
            if (Hash::check($request['password'], $userExist->password)) {
                $accessToken = $this->generateAccessToken($userExist);
                $userData = [
                    'employee_id' => $getUserInfo->employee_id,
                    'email' => $getUserInfo->email,
                    'full_name' => $getUserInfo->full_name,
                    'nick_name' => $getUserInfo->nick_name,
                    'phone_number' => $getUserInfo->phone_number,
                    'user_id' => $getUserInfo->id,
                    'branch' => $getUserInfo->branch_name,
                    'department' => $getUserInfo->department_name,
                    'designation' => $getUserInfo->designation_name,
                    'role' => $getUserInfo->role_name,
                    'photo' => $getUserInfo->image,
                ];

                $data = [
                    'user' => $userData,
                    'token' => $accessToken,
                ];

                return $data;

            }
        } catch (\Exception $exception) {
            return response(['success' => false, 'error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function generateAccessToken($user)
    {
        return 'Bearer' . ' ' . $user->createToken('appnap_hrm')->accessToken;
    }
}
