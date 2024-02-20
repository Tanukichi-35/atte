<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'date',
        'work_start',
        'work_end',
    ];

    // Userモデルとの紐づけ
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // Restモデルとの紐づけ
    public function rests(){
        return $this->hasMany('App\Models\Rest');
    }

    // ユーザー名の取得
    public function getName()
    {
        $user = User::find($this->user_id);
        return $user->name;
    }

    // 勤務時間の取得
    public function getWorkTime()
    {
        if(is_null($this->work_end)){
            return null;
        }
        else{
            $work_start = new DateTime($this->work_start);
            $work_end = new DateTime($this->work_end);
            $work_time = $work_start->diff($work_end);
            return $work_time->format("%H:%I:%S");
        }
    }

    // 休憩時間の取得
    // 勤怠アイテムと紐づいている休憩アイテムを全て取得し、合算
    public function getBreakTime()
    {
        $break_time = new DateTime("00:00:00");
        $rests = Attendance::find($this->id)->rests;
        foreach ($rests as $rest) {
            $break_start = new DateTime($rest->break_start);
            $break_end = new DateTime($rest->break_end);
            $break_time->add($break_start->diff($break_end));
        }
        return $break_time->format("H:i:s");
    }

    // 勤怠IDが一致する休憩アイテムのうち、break_endがnullのアイテムを取得
    public function getRest(){
        return Attendance::find($this->id)->rests->whereNull("break_end")->first();
    }

    // 日付が一致するアイテムを取得し、5件毎にページ割り
    public static function getAttendances(string $date){
        return Attendance::where("date", $date)->Paginate(5);
    }
}
