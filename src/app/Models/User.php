<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Attendanceモデルとの紐づけ
    public function attendances(){
        return $this->hasMany('App\Models\Attendance');
    }

    // ステータスによってメッセージを切り替え
    public function getMessage()
    {
        $attendance = $this->getAttendance();
        // dd($attendance);
        if(is_null($attendance)){     // 勤務開始前
            return sprintf("%sさん、おはようございます！", $this->name);
        }
        else if($attendance->status === 1){     // 勤務中
            return sprintf("%sさん、お疲れ様です！", $this->name);
        }
        else if($attendance->status === 2){     // 勤務終了
            return sprintf("%sさん、お疲れ様でした！", $this->name);
        }
        else if($attendance->status === 3){     // 休憩中
            return sprintf("%sさん、少し休憩しましょう！", $this->name);
        }
    }

    // ステータスを取得
    public function getStatus(){
        $attendance = $this->getAttendance();
        if(empty($attendance)){     // データが存在しない場合は、0を返す
            return 0;
        }
        else{
            return $attendance->status;
        }
    }

    // 勤怠IDを取得
    public function getAttendanceID(){
        $attendance = $this->getAttendance();
        if(empty($attendance)){     // データが存在しない場合は、0を返す
            return 0;
        }
        else{
            return $attendance->id;
        }
    }

    // 休憩IDを取得
    public function getRestID(){
        $attendance = $this->getAttendance();
        if(empty($attendance)){     // データが存在しない場合は、0を返す
            return 0;
        }
        else{
            $rest = $attendance->getRest($attendance->id);
            if(empty($rest)){     // データが存在しない場合は、0を返す
                return 0;
            }
            else{
                return $rest->id;
            }
        }
    }

    // ユーザーと日付が一致する勤怠アイテムを取得
    public function getAttendance(){
        return User::find($this->id)->attendances->where("date", date('Y-m-d'))->first();
    }
}
