<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthRepository
{
    private $userId, $password, $employeeId;

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        return $this;
    }
    public function userExist()
    {
        return User::where('employee_id', $this->employeeId)->first();
    }
    public function getUserInfo()
    {
        return DB::table('users as u')
        ->leftJoin('basic_info as bi', function ($join) {
            $join->on('u.id', '=', 'bi.user_id');
        })
        ->leftJoin('branches as b', function ($join) {
            $join->on('b.id', '=', 'bi.branch_id');
        })
        ->leftJoin('departments as dept', function ($join) {
            $join->on('dept.id', '=', 'bi.department_id');
        })
        ->leftJoin('designations as desg', function ($join) {
            $join->on('desg.id', '=', 'bi.designation_id');
        })
        ->leftJoin('roles as r', function ($join) {
            $join->on('r.id', '=', 'bi.role_id');
        })
        ->where('employee_id', '=', $this->employeeId)
        ->select('u.*', 'b.name as branch_name', 'dept.name as department_name', 'desg.name as designation_name', 'r.name as role_name')
        ->first();
    }

}
