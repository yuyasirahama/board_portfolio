<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Models\Post;
use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

class BookmarkController extends Controller
{   
    //ブックマークページ
    public function index()
    {   
        Paginator::useBootstrap();
        $id = Auth::user()->id;

        //ブックマークテーブルから、ログインユーザーがブックマークしている投稿のidを$bookmarksに入れる
        $bookmarks = Bookmark::select('post_id')->where('user_id', '=', $id)->get();

        //コレクション型の$bookmarksの中身を$post_idに入れる
        $post_id = array();
        foreach($bookmarks as $bookmark){
            array_push($post_id, $bookmark->post_id);
        }

        //postsテーブルの該当idのレコードを格納する
        $posts = new Post();
        $posts_reverse = $posts->whereIn('id', $post_id)->orderBy("created_at", "desc")->paginate(20);

        return view('users.bookmarks.bookmark', [
            'id' => $id,
            'posts_reverse' => $posts_reverse,
            'post_id' => $post_id,
        ]);
    }

    //投稿削除処理
    public function Destroy(Request $request)
    {   
        $the_post_id = $request->post_id;

        $the_post = Post::find($the_post_id);
        $bookmark = Bookmark::where('post_id', $the_post_id);

        $bookmark->delete();
        $the_post->delete();
        
        return to_route('bookmark.index');
    }

    //ブックマーク削除処理
    public function bookmarkDestroy(Request $request)
    {   
        $user_id = Auth::user()->id;
        $the_post_id = $request->post_id;

        Bookmark::where('user_id', $user_id)->where('post_id', $the_post_id)->delete();

        return to_route('bookmark.index');
    }

}