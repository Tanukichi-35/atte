<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'work_start',
        'work_end',
        'break_start',
        'break_time',
    ];

    // ユーザーIDの取得
    public function getName()
    {
        $user = User::find($this->user_id);
        return $user->name;
    }

    // 勤務時間の取得
    public function getWorkTime()
    {
        if($this->status != 2){
            return null;
        }

        return $this->calcInterval($this->work_start, $this->work_end);
    }

    // 休憩時間の取得
    public function getBreakTime(string $break_time, string $break_start, string $break_end)
    {
        $time_add = $this->calcInterval($break_start, $break_end);
        $break_time = $this->addTime($break_time, $time_add);

        return $break_time;
    }

    // 時間の差を取得
    public function calcInterval(string $start_at, string $end_at){
        $start_at = explode(":", $start_at);
        $end_at = explode(":", $end_at);
        $hour = (int)$end_at[0] - (int)$start_at[0];
        if($hour < 0){          // 日を跨いで勤務した場合
            $hour += 24;
        }
        $minute = (int)$end_at[1] - (int)$start_at[1];
        $second = (int)$end_at[2] - (int)$start_at[2];
        $Interval = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        return $Interval;
    }

    // 時間を追加
    public function addTime(string $time, string $time_add){
        $time = explode(":", $time);
        $time_add = explode(":", $time_add);
        $hour = (int)$time[0] + (int)$time_add[0];
        $minute = (int)$time[1] + (int)$time_add[1];
        $second = (int)$time[2] + (int)$time_add[2];
        $sum = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        return $sum;
    }

    // 日付が一致するアイテムを取得
    public static function getAttendances(string $date){
        // return Attendance::where("created_at", "LIKE", $date."%")->get();
        return Attendance::where("created_at", "LIKE", $date."%")->Paginate(5);
    }
}
