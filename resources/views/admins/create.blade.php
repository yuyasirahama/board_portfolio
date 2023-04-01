@extends('layouts.admin')
@section('title', '管理者ユーザー作成')

@section('content')
    <h1>管理者ユーザー作成</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <label>名前:<input type="text" name="name" value="{{ old('name') }}"></label>
        <label>メールアドレス:<input type="email" name="email" value="{{ old('email') }}"></label>
        <label>パスワード:<input type="password" name="password"></label>
        <label>パスワード(確認):<input type="password" name="password_confirmation"></label>
        <button type="submit">登録</button>
    </form>
@endsection