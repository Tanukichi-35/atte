<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;

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
        // ５件ごとに表示
        $attendances = Attendance::Paginate(5);
        return view('attendance', compact('attendances'));
    }
}
