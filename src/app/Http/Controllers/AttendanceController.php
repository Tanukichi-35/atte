<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use DateTime;

class AttendanceController extends Controller
{
    // 勤務開始
    public function workStart(Request $request){
      // 新しく勤怠アイテムを作成
      Attendance::create([
        'user_id' => $request->user_id,
        'status' => 1,  // 勤務中
        'date' => new DateTime('now'),
        'work_start' => new DateTime('now'),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }

    // 勤務終了
    public function workEnd(Request $request){
      // IDから勤怠アイテムを取得
      $attendance = Attendance::find($request->attendance_id);
      // 勤怠アイテムを更新
      $attendance->update([
        'status' => 2,  // 勤務終了
        'work_end' => new DateTime('now'),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }
}
