<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use DateTime;

class AuthController extends Controller
{
    public function index()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();
        return view('index', compact('user'));
    }

    public function attendance()
    {
        // 日付を取得
        $date = date('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }

    public function attendancePrevious($strDate)
    {
        $date = DateTime::createFromFormat('Y-m-d', $strDate);
        $date->modify('-1 day');
        // dd($date);
        // 日付を取得
        $date = $date->format('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }

    public function attendanceNext($strDate)
    {
        $date = DateTime::createFromFormat('Y-m-d', $strDate);
        $date->modify('+1 day');
        // 日付を取得
        $date = $date->format('Y-m-d');
        // 日付が一致するデータを取得
        $attendances = Attendance::getAttendances($date);

        return view('attendance', compact('attendances', 'date'));
    }
}
