<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd($user);
        return view('index', compact('user'));
    }

    public function attendance()
    {
        // $date = $_GET["date"];
        // dd($date);
        // $users = User::All();
        $attendances = Attendance::Paginate(5);
        return view('attendance', compact('attendances'));
    }
}
