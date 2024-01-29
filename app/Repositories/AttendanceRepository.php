<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    private $user_id, $in_time, $out_time, $in_time_latitude, $in_time_longitude, $in_time_location, $out_time_latitude, $out_time_longitude, $out_time_location, $created_at;
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }
    public function setInTime($in_time)
    {
        $this->in_time = $in_time;
        return $this;
    }
    public function setOutTime($out_time)
    {
        $this->out_time = $out_time;
        return $this;
    }
    public function setInTimeLatitude($in_time_latitude)
    {
        $this->in_time_latitude = $in_time_latitude;
        return $this;
    }
    public function setInTimeLongitude($in_time_longitude)
    {
        $this->in_time_longitude = $in_time_longitude;
        return $this;
    }
    public function setInTimeLocation($in_time_location)
    {
        $this->in_time_location = $in_time_location;
        return $this;
    }
    public function setOutTimeLatitude($out_time_latitude)
    {
        $this->out_time_latitude = $out_time_latitude;
        return $this;
    }
    public function setOutTimeLongitude($out_time_longitude)
    {
        $this->out_time_longitude = $out_time_longitude;
        return $this;
    }
    public function setOutTimeLocation($out_time_location)
    {
        $this->out_time_location = $out_time_location;
        return $this;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    public function getUserInfo()
    {
        return User::where('id', $this->user_id)->first();
    }
    public function saveClockIn()
    {
        return DB::table('attendance')
            ->insert([
                'user_id' => $this->user_id,
                'in_time' => $this->in_time,
                'in_time_location'=> $this->in_time_location,
                'in_time_latitude'=> $this->in_time_latitude,
                'in_time_longitude'=> $this->in_time_longitude,
                'created_at' => $this->created_at,
            ]);
    }
    public function saveClockOut()
    {

        $previous_data = DB::table('attendance')->latest('in_time')->first();
        $previous_date = date('d-m-Y', ($previous_data->in_time / 1000));
        $current_date = Carbon::now()->format('d-m-Y');

        if($previous_date == $current_date) {
            return DB::table('attendance')
            ->insert([
                'user_id' => $this->user_id,
                'in_time' => $previous_data->in_time,
                'out_time' => $this->out_time,
                'out_time_location'=> $this->out_time_location,
                'out_time_latitude'=> $this->out_time_latitude,
                'out_time_longitude'=> $this->out_time_longitude,
                'created_at' => $this->created_at,
            ]);
        }  else {
            return false;
        }
    }

}
