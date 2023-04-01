@extends('layouts.default')
@section('title', 'ユーザー')

@section('content')
    <h1>ユーザー</h1>
    <h2>ようこそ、{{ \Auth::user()->name }}さん</h2>

    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <form action="{{ route('user.update') }}" method="post">
        @csrf
        <label>名前変更:<input type="text" name="name" value="{{ old('name') }}"></label>
        <button type="submit">確定</button>
    </form>
    <br>
    <form action="{{ route('user.logout') }}" method="post">
        @csrf
        <button type='submit'>ログアウト</button>
    </form>
@endsection