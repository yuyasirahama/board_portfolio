@extends('layouts.default')
@section('title', '掲示板')

@section('header')
            <li><a class="current" href="{{ route('board.index') }}">掲示板</a></li>
            <li><a href="{{ route('bookmark.index') }}">ブックマーク</a></li>
            <li><a href="{{ route('user.index') }}">ユーザー</a></li>
@endsection

@section('content')
    <h1>掲示板</h1>
    <!-- 未検索時 -->
    @if($search_cnt == 0)
        @if($errors->any())
                    @foreach($errors->all() as $error)
                    <div style="color:red;">{{ $error }}</div>
                    @endforeach
        @endif
        <form action="{{ route('board.session') }}" method="post">
            @csrf
            <input type="text" name="text">
            <button type="submit">検索</button>
        </form>
        <br>
        <div style="display:inline-flex">
        <form action="{{ route('board.storeText') }}" method="post">
            @csrf
            <textarea name="text" id="" cols="50" rows="4"></textarea>
            <button type="submit">投稿</button>
        </form>
        <form action="{{ route('board.storeImage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image">
            <button type="submit">画像投稿</button>
        </form>
        </div>
        {{ $posts_reverse->links() }}
        @foreach($posts_reverse as $post)
        @php
            $posted_user_id = $post->user_id;
            $posted_user = \App\Models\User::find($posted_user_id);
        @endphp
            <hr>
            <table>
                <tr>
                    <td>{{ $post->id }}</td>
                    <td class="name">{{ $posted_user->name }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                    @if(in_array($post->id, $post_id))
                    <form action="{{ route('board.bookmarkDestroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">★</button>
                    </form>
                    @else
                    <form action="{{ route('board.bookmark') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">☆</button>
                    </form>
                    @endif
                    </td>
                    @if($id == $posted_user_id)
                        <td>
                            <form action="{{ route('board.destroy') }}" method="post">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    @endif
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
    @endif

    <!-- 検索時 -->
    @if($search_cnt == 1)
        <a href="{{ route('board.index') }}" class="button001">戻る</a>
        <div>「{{ Session::get('search') }}」を含む投稿</div>
        {{ $search_posts->links() }}
        @foreach($search_posts as $post)
        @php
            $posted_user_id = $post->user_id;
            $posted_user = \App\Models\User::find($posted_user_id);
        @endphp
            <hr>
            <table>
                <tr>
                    <td>{{ $post->id }}</td>
                    <td class="name">{{ $posted_user->name }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                    @if(in_array($post->id, $post_id))
                    <form action="{{ route('board.searchBookmarkDestroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">★</button>
                    </form>
                    @else
                    <form action="{{ route('board.searchBookmark') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">☆</button>
                    </form>
                    @endif
                    </td>
                    @if($id == $posted_user_id)
                        <td>
                            <form action="{{ route('board.searchDestroy') }}" method="post">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    @endif
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
        {{ $search_posts->links() }}
    @endif
@endsection