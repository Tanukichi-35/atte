@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('link')
<ul>
  <li><a href="">ホーム</a></li>
  <li><a href="">日付一覧</a></li>
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
  <h2 class="h2__atte">〇〇さんお疲れ様です！</h2>
  <form method="POST" class="form__atte">
    @csrf
    <div class="div__menu">
      <div class="div__menu-upper">
        <button formaction="/work-start" class="button__work-start">勤務開始</button>
        <button formaction="/work-end" class="button__work-end">勤務終了</button>
      </div>
      <div class="div__menu-lower">
        <button formaction="/break-start" class="button__break-start">休憩開始</button>
        <button formaction="/break-end" class="button__break-end">休憩終了</button>
      </div>
    </div>
  </form>
</div>
@endsection