@extends('layouts.default')
@section('title', 'ユーザーログイン')

@section('header')
            <li><a href="{{ route('guest.index') }}">掲示板</a></li>
            <li><a class="current" href="{{ route('user.auth') }}" >ユーザー</a></li>
            <li><a href="{{ route('admin.loginForm') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>ユーザーログイン</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('user.login') }}" method="post">
        @csrf
        <label>メールアドレス:<input type="email" name="email" value="{{ old('email') }}"></label>
        <label>パスワード:<input type="password" name="password"></label>
        <button type="submit">ログイン</button>
    </form>
    <br><br><br>
    <a href="{{ route('guest.create') }}" class="button001">ユーザー作成</a>
@endsection