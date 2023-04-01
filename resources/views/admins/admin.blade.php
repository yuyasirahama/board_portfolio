@extends('layouts.admin')
@section('title', 'アドミン')

@section('header')
            <li><a  href="{{ route('admin.index') }}">ユーザー情報</a></li>
            <li><a class="current" href="{{ route('admin.admin') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>アドミン</h1>
    <h2>ようこそ、{{ \Auth::user()->name }}さん</h2>
    <form action="{{ route('admin.logout') }}" method="post">
        @csrf
        <button type='submit' class="button001">ログアウト</button>
    </form>
@endsection