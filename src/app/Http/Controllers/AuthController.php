<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use DateTime;

class AuthController extends Controller
{
    // 打刻ページを表示
    public function index(){
        // ログイン中のユーザーを取得
        $user = Auth::user();
        return view('index', compact('user'));
    }

    // 日付別勤怠ページを表示
    public function attendance(){
        // 日付を取得
        $date = date('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }

    // 一つ前の日付の勤怠ページを表示
    public function attendancePrevious($strDate){
        // 表示中の日付を取得し、一日進める
        $date = DateTime::createFromFormat('Y-m-d', $strDate);
        $date->modify('-1 day');

        // 日付を取得
        $date = $date->format('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }

    // 一つ後の日付の勤怠ページを表示
    public function attendanceNext($strDate){
        // 表示中の日付を取得し、一日戻す
        $date = DateTime::createFromFormat('Y-m-d', $strDate);
        $date->modify('+1 day');

        // 日付を取得
        $date = $date->format('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }

    // ユーザー一覧ページを表示
    public function user(){
        // 全ユーザーを取得
        $users = User::getUsers();

        return view('user', compact('users'));
    }

    // ユーザー別勤怠ページを表示
    public function userAttendance($user_id){
        // ユーザーIDが一致するユーザーを取得
        $user = User::find($user_id);

        // ユーザーが一致する勤怠データを取得
        $attendances = Attendance::Where('user_id', $user_id)->Paginate(5);

        // dd($user, $attendances);
        return view('userAttendance', compact('user','attendances'));
    }
}
