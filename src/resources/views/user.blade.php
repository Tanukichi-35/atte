@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
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
  <h2 class="h2__user">ユーザー一覧</h2>
  <table class="table__users">
    <tr class="tr__header">
      <th style="width: 30%">名前</th>
      <th style="width: 50%">メールアドレス</th>
      <th style="width: 20%">個別の勤務状況</th>
    </tr>
    @foreach ($users->all() as $user)
    <tr class="tr__contents">
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>
        <a href="/user/{{$user->id}}">表示</a>
      </td>
    </tr>
    @endforeach
  </table>
  {{ $users->links('vendor.pagination.topics') }}
</div>
@endsection