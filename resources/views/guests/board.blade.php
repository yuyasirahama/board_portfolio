@extends('layouts.guest')
@section('title', '掲示板')

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
        <a href="{{ route('guest.index') }}" class="button001">戻る</a>
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