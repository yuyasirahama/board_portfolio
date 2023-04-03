@extends('layouts.guest')
@section('title', '掲示板')

@section('header')
            <li><a class="current" href="{{ route('guest.index') }}">掲示板</a></li>
            <li><a href="{{ route('user.auth') }}" >ユーザー</a></li>
            <li><a href="{{ route('admin.loginForm') }}">アドミン</a></li>
@endsection

@section('content')
    <h1>掲示板</h1>
    @if($errors->any())
                @foreach($errors->all() as $error)
                <div style="color:red;">{{ $error }}</div>
                @endforeach
    @endif
    <!-- 未検索時 -->
    @if($search_cnt == 0)
        <form action="{{ route('guest.session') }}" method="post">
            @csrf
            <input type="text" name="text">
            <button type="submit">検索</button>
        </form>

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
                    <td class="name">
                        <form action="{{ route('guest.indivisual') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                            <button type="submit" style="
                                                            background-color: transparent;
                                                            border: none;
                                                            cursor: pointer;
                                                            outline: none;
                                                            padding: 0;
                                                            appearance: none;
                                                            font-size: 18px;
                                                            "
                                                            >
                                                            {{ $posted_user->name }}
                                                        </button>
                        </form>
                    </td>
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
    @endif
    
    <!-- 検索時 -->
    @if($search_cnt == 1)
        <button type="button" onClick="history.back()">戻る</button>
        <div>「{{ Session::get('search') }}」を含む投稿</div>

        {{ $search_posts->links() }}
        @if (count($search_posts) >0)
        <p>全{{ $search_posts->total() }}件中 
            {{  ($search_posts->currentPage() -1) * $search_posts->perPage() + 1}} - 
            {{ (($search_posts->currentPage() -1) * $search_posts->perPage() + 1) + (count($search_posts) -1)  }}件の投稿が表示されています。</p>
        @else
        <p>投稿がありません</p>
        @endif 

        @foreach($search_posts as $post)
        @php
            $posted_user_id = $post->user_id;
            $posted_user = \App\Models\User::find($posted_user_id);
        @endphp
            <hr>
            <table>
                <tr>
                    <td>{{ $post->id }}</td>
                    <td class="name">
                        <form action="{{ route('guest.searchIndivisual') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                            <button type="submit" style="
                                                            background-color: transparent;
                                                            border: none;
                                                            cursor: pointer;
                                                            outline: none;
                                                            padding: 0;
                                                            appearance: none;
                                                            font-size: 18px;
                                                            "
                                                            >
                                                            {{ $posted_user->name }}
                                                        </button>
                        </form>
                    </td>
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
        {{ $search_posts->links() }}
    @endif
@endsection