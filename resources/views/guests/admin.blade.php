@extends('layouts.admin')
@section('title', 'アドミン')

@section('content')
    <h1>アドミンログイン</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('admin.login') }}" method="post">
        @csrf
        <label>メールアドレス:<input type="email" name="email" value="{{ old('email') }}"></label>
        <label>パスワード:<input type="password" name="password"></label>
        <button type="submit">ログイン</button>
    </form>
@endsection