<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use DateTime;

class RestController extends Controller
{
    // 休憩開始
    public function breakStart(Request $request){
      // IDから勤怠アイテムを取得
      $attendance = Attendance::find($request->attendance_id);
      // 勤怠アイテムを更新
      $attendance->update([
        'status' => 3,  // 休憩中
      ]);

      // 新しく休憩アイテムを作成
      Rest::create([
        'attendance_id' => $request->attendance_id,
        'break_start' => new DateTime(),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }

    // 休憩終了
    public function breakEnd(Request $request){
      // IDから勤怠アイテムを取得
      $attendance = Attendance::find($request->attendance_id);
      // 勤怠アイテムを更新
      $attendance->update([
        'status' => 1,  // 勤務中
      ]);

      // IDから休憩アイテムを取得
      $rest = Rest::find($request->rest_id);
      // 休憩アイテムを更新
      $rest->update([
        'break_end' => new DateTime(),
      ]);

      // 画面を更新
      return redirect('/')->withInput();
    }
}
