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

    // ユーザー名の取得
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

        // 差を取得
        $second = $this->convertSecond($this->work_end) - $this->convertSecond($this->work_start);
        // 時間に変換
        $time = $this->convertTime($second);

        return $time;
    }

    // 休憩時間の取得
    public function getBreakTime(string $break_end)
    {
        // 差を取得
        $second = $this->convertSecond($break_end) - $this->convertSecond($this->break_start);
        // 加算
        $second += $this->convertSecond($this->break_time);
        // 時間に変換
        $time = $this->convertTime($second);

        return $time;
    }

    // 時間文字列を整数秒に変換
    public function convertSecond(string $time){
        $time = explode(":", $time);
        $second = (int)$time[0]*3600 + (int)$time[1]*60 + (int)$time[2];

        return $second;
    }

    // 整数秒を時間文字列に変換
    public function convertTime(int $second){
        $hour = (int)($second / 3600);
        $second = $second % 3600;
        $minute = (int)($second / 60);
        $second = $second % 60;
        $time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        return $time;
    }

    // 日付が一致するアイテムを取得し、5件毎にページ割り
    public static function getAttendances(string $date){
        // return Attendance::where("created_at", "LIKE", $date."%")->get();
        return Attendance::where("created_at", "LIKE", $date."%")->Paginate(5);
    }
}
