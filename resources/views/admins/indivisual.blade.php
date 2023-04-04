@extends('layouts.default')
@section('title', 'ユーザー情報')

@section('header')
            <li><a class="current" href="{{ route('admin.index') }}">ユーザー情報</a></li>
            <li><a href="{{ route('admin.admin') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>ユーザー情報</h1>
        <a href="{{ route('admin.index') }}" class="button001">戻る</a>
    <h3>{{ $name }}さんの投稿一覧</h3>
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
                <td>
                    <form action="{{ route('admin.indivisualDestroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">削除</button>
                    </form>
                </td>
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