@extends('layouts.default')
@section('title', 'ブックマーク')

@section('header')
            <li><a href="{{ route('board.index') }}">掲示板</a></li>
            <li><a class="current" href="{{ route('bookmark.index') }}">ブックマーク</a></li>
            <li><a href="{{ route('user.index') }}">ユーザー</a></li>
@endsection

@section('content')
    <h1>ブックマーク</h1>
    <h2>{{ $name }}さんの投稿一覧</h2>
    <button type="button" onClick="history.back()">戻る</button>

    {{ $posts_reverse->links() }}
    @if (count($posts_reverse) >0)
    <p>全{{ $posts_reverse->total() }}件中 
        {{  ($posts_reverse->currentPage() -1) * $posts_reverse->perPage() + 1}} - 
        {{ (($posts_reverse->currentPage() -1) * $posts_reverse->perPage() + 1) + (count($posts_reverse) -1)  }}件の投稿が表示されています。</p>
    @else
    <p>投稿がありません</p>
    @endif 

    @foreach($posts_reverse as $post)
    @php
        $posted_user_id = $post->user_id;
        $posted_user = \App\Models\User::find($posted_user_id);
    @endphp
        <hr>
        <table>
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->created_at }}</td>
            </tr>
        </table>
        <table>
            @if($post->text)
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td colspan="2">{{ $post->text }}</td>
            </tr>
            @endif
            @if($post->image)
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <img src="{{ asset('storage/'.$post->image) }}" width="500" alt="">
            </tr>
            @endif
        </table>
    @endforeach
    {{ $posts_reverse->links() }}
@endsection