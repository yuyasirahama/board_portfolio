@extends('layouts.default')
@section('title', 'ブックマーク')

@section('content')
<h1>ブックマーク</h1>
    {{ $posts_reverse->links() }}
    @foreach($posts_reverse as $post)
    @php
        $posted_user_id = $post->user_id;
        $posted_user = \App\Models\User::find($posted_user_id);
    @endphp
    @if(in_array($post->id, $post_id))
        <hr>
        <table>
            <tr>
                <td>{{ $post->id }}</td>
                <td class="name">{{ $posted_user->name }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    <form action="{{ route('bookmark.bookmarkDestroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">★</button>
                    </form>
                </td>
                @if($id == $posted_user_id)
                    <td>
                        <form action="{{ route('bookmark.destroy') }}" method="post">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit">削除</button>
                        </form>
                    </td>
                @endif
            </tr>
        </table>
        <table>
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
        </table>
    @endif
    @endforeach
    {{ $posts_reverse->links() }}
@endsection