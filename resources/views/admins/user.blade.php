@extends('layouts.default')
@section('title', 'アドミン')

@section('header')
            <li><a class="current" href="{{ route('admin.index') }}">ユーザー情報</a></li>
            <li><a  href="{{ route('admin.admin') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>ユーザー情報</h1>
    {{ $users_reverse->links() }}
    @foreach($users_reverse as $user)
        <hr>
        <table>
            <tr>
                <td>
                    <form action="{{ route('admin.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button>ユーザー削除</button>
                    </form>
                </td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        </table>
    @endforeach
@endsection