<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Attendance;

class User extends Authenticatable
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

    // ステータスによってメッセージを切り替え
    public function getMessage()
    {
        $attendance = $this->getAttendance($this->id);
        // dd($attendance);
        if(is_null($attendance)){
            return sprintf("%sさん、おはようございます！", $this->name);
        }
        else if($attendance->status === 1){
            return sprintf("%sさん、お疲れ様です！", $this->name);
        }
        else if($attendance->status === 2){
            return sprintf("%sさん、お疲れ様でした！", $this->name);
        }
        else if($attendance->status === 3){
            return sprintf("%sさん、少し休憩しましょう！", $this->name);
        }
    }

    // ステータスを取得
    public function getStatus(){
        $attendance = $this->getAttendance($this->id);
        if(empty($attendance)){
            return 0;
        }
        else{
            return $attendance->status;
        }
    }

    // IDを取得
    public function getAttendanceID(){
        $attendance = $this->getAttendance($this->id);
        if(empty($attendance)){
            return 0;
        }
        else{
            return $attendance->id;
        }
    }

    // ユーザーと日付が一致するアイテムを取得
    public static function getAttendance(int $user_id){
        return Attendance::where("user_id", $user_id)->where("created_at", "LIKE", date('Y-m-d')."%")->first();
    }
}
