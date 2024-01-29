<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceService
{
    private $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function clockIn($request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = Carbon::now();
        $timeInMilliseconds = $date->valueOf();
        $lat = $request['latitude'];
        $long = $request['longitude'];
        $location = $request['location'];
        $user = $this->getLoggedUserInfo();
        $clock_in = $this->attendanceRepository->setUserId(Auth::user()['id'])
                                    ->setInTime($timeInMilliseconds)
                                    ->setInTimeLatitude($lat)
                                    ->setInTimeLongitude($long)
                                    ->setInTimeLocation($location)
                                    ->setCreatedAt(date('Y-m-d H:i:s'))
                                    ->saveClockIn();
        $data =null;
        if($clock_in!=0)
        {
            $data = [
                'user' => $user,
                'location' => $location,
                'latitude' => $lat,
                'longitude' => $long,
                'date' => $date->format('M d, Y h:i a'),
            ];
        }
        return $data;
    }
    public function getLoggedUserInfo()
    {
        return [
            'employee_id' => Auth::user()['employee_id'],
            'email' => Auth::user()['email'],
            'full_name' => Auth::user()['full_name'],
            'nick_name' => Auth::user()['nick_name'],
            'phone_number' => Auth::user()['phone_number'],
            'user_id' => Auth::user()['id'],
        ];
    }

    public function clockOut($request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = Carbon::now();
        $timeInMilliseconds = $date->valueOf();
        $lat = $request['latitude'];
        $long = $request['longitude'];
        $location = $request['location'];
        $userId = Auth::user()['id'];
        $userInfo = $this->attendanceRepository->setUserId($userId)->getUserInfo();
        $clock_out = $this->attendanceRepository->setUserId($userId)
                                    ->setOutTime($timeInMilliseconds)
                                    ->setOutTimeLatitude($lat)
                                    ->setOutTimeLongitude($long)
                                    ->setOutTimeLocation($location)
                                    ->setCreatedAt(date('Y-m-d H:i:s'))
                                    ->saveClockOut();
        $data ='';
        if($clock_out) {
            $userData = [
                'user_id' => $userInfo->id,
                'employee_id' => $userInfo->employee_id,
                'email' => $userInfo->email,
                'full_name' => $userInfo->full_name,
                'nick_name' => $userInfo->nick_name,
                'phone_number' => $userInfo->phone_number,
            ];
            $data = [
                'user' => $userData,
                'location' => $location,
                'latitude' => $lat,
                'longitude' => $long,
                'date' => $date->format('M d,y H:i'),
            ];
            return $data;
        } else {
            return false;
        }
    }

}
