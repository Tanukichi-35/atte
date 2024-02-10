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
        'break_time',
    ];

    public function getName()
    {
        $user = User::find($this->user_id);
        return $user->name;
    }

    public function getWorkTime()
    {
        $start_at = explode(":", $this->work_start);
        $end_at = explode(":", $this->work_end);
        $hour = (int)$end_at[0] - (int)$start_at[0];
        if($hour < 0){
            $hour += 24;
        }
        $minute = (int)$end_at[1] - (int)$start_at[1];
        $second = (int)$end_at[2] - (int)$start_at[2];
        $work_time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        return $work_time;
    }
}
