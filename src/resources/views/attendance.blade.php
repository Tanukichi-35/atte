@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('link')
<ul>
  <li><a href="/">ホーム</a></li>
  <li><a href="/attendance">日付一覧</a></li>
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
  <nav class="nav__date">
    <li>
      <a href={{"/attendance/previous/".$date}} rel="prev" aria-label="@lang('pagination.previous')">&lt;</a>
      <p >{{$date}}</p>
      <a href={{"/attendance/next/".$date}} rel="next" aria-label="@lang('pagination.next')">&gt;</a>
    </li>
  </nav>
  <table class="table__attendances">
    <tr class="tr__header">
      <th>名前</th>
      <th>勤務開始</th>
      <th>勤務終了</th>
      <th>休憩時間</th>
      <th>勤務時間</th>
    </tr>
    @foreach ($attendances->all() as $attendance)
    <tr class="tr__contents">
      <td>{{$attendance->getName()}}</td>
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