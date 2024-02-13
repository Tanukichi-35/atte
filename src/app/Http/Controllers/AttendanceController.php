<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 勤務開始
    public function workStart(Request $request){
      // 新しくアイテムを作成
      Attendance::create([
        'user_id' => $request->user_id,
        'status' => 1,  // 勤務中
        'work_start' => date('H:i:s'),
        'break_start' => date('00:00:00'),
        'break_time' => date('00:00:00'),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }

    // 勤務終了
    public function workEnd(Request $request){
      // IDからアイテムを取得
      $attendance = Attendance::find($request['attendance_id']);

      // アイテムを更新
      $attendance->update([
        'status' => 2,  // 勤務終了
        'work_end' => date('H:i:s'),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }

    // 休憩開始
    public function breakStart(Request $request){
      // IDからアイテムを取得
      $attendance = Attendance::find($request['attendance_id']);

      // アイテムを更新
      $attendance->update([
        'status' => 3,  // 休憩中
        'break_start' => date('H:i:s'),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }

    // 休憩終了
    public function breakEnd(Request $request){
      // IDからアイテムを取得
      $attendance = Attendance::find($request['attendance_id']);

      // アイテムを更新
      $attendance->update([
        'status' => 1,  // 勤務中
        'break_time' => $attendance->getBreakTime(date('H:i:s')),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }
}
