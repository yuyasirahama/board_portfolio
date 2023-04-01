@extends('layouts.guest')
@section('title', '管理者ログイン')

@section('header')
            <li><a href="{{ route('guest.index') }}">掲示板</a></li>
            <li><a href="{{ route('user.auth') }}" >ユーザー</a></li>
            <li><a class="current" href="{{ route('admin.loginForm') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>アドミン</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <label>メールアドレス:<input type="email" name="email" value="{{ old('email') }}"></label>
        <label>パスワード:<input type="password" name="password"></label>
        <button type="submit">ログイン</button>
    </form>
@endsection