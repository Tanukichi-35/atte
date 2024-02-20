@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('link')
<ul>
  <li><a href="/">ホーム</a></li>
  <li><a href="/attendance">日付一覧</a></li>
  <li><a href="/user">ユーザー一覧</a></li>
  <li>
    <form action="/logout" method="POST">
      @csrf
      <button>ログアウト</button>
    </form>
  </li>
</ul>
@endsection

@section('content')
<div class="div__main">
  <h2 class="h2__username">{{$user->name}}さんの勤務状況</h2>
  <table class="table__attendances">
    <tr class="tr__header">
      <th>日付</th>
      <th>勤務開始</th>
      <th>勤務終了</th>
      <th>休憩時間</th>
      <th>勤務時間</th>
    </tr>
    @foreach ($attendances->all() as $attendance)
    <tr class="tr__contents">
      <td>{{$attendance->date}}</td>
      <td>{{$attendance->work_start}}</td>
      <td>{{$attendance->work_end}}</td>
      <td>{{$attendance->getBreakTime()}}</td>
      <td>{{$attendance->getWorkTime()}}</td>
    </tr>
    @endforeach
  </table>
  {{ $attendances->links('vendor.pagination.topics') }}
</div>
@endsection