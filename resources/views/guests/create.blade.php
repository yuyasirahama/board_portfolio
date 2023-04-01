@extends('layouts.guest')
@section('title', 'ユーザー作成')

@section('content')
    <h1>ユーザー作成</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('guest.store') }}" method="post">
        @csrf
        <label>名前:<input type="text" name="name" value="{{ old('name') }}"></label>
        <label>メールアドレス:<input type="email" name="email" value="{{ old('email') }}"></label>
        <label>パスワード:<input type="password" name="password"></label>
        <label>パスワード(確認):<input type="password" name="password_confirmation"></label>
        <button type="submit">登録</button>
    </form>
    <br><br><br>
    <a href="{{ route('user.auth') }}" class="button001">ログイン</a>
@endsection