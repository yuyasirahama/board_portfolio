<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTextRequest;
use App\Http\Requests\StoreImageRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

class BoardController extends Controller
{
    //掲示板トップページ
    public function index()
    {   
        Paginator::useBootstrap();
        $id = Auth::user()->id;

        $posts_reverse = Post::orderBy("created_at", "desc")->paginate(20);

        //ブックマーク機能
        $bookmarks = Bookmark::select('post_id')->where('user_id', '=', $id)->get();
        
        $post_id = array();
        foreach($bookmarks as $bookmark){
            array_push($post_id, $bookmark->post_id);
        }

        $search_posts=null;
        $search_cnt=0;

        return view('users.boards.board', [
            'id' => $id,
            'posts_reverse' => $posts_reverse,
            'search_posts' => $search_posts,
            'search_cnt' => $search_cnt,
            'post_id' => $post_id,
        ]);
    }
    
    //投稿保存処理
    public function storeText(StoreTextRequest $request)
    {   
        $user_id = Auth::user()->id;

        $validated = $request->validated();

        $validated = array_merge($validated, array('user_id' => $user_id));

        Post::create($validated);

        return to_route('board.index');
    }

    //投稿削除処理
    public function destroy(Request $request)
    {   
        $the_post_id = $request->post_id;

        $the_post = Post::find($the_post_id);
        $bookmark = Bookmark::where('post_id', $the_post_id);

        $bookmark->delete();
        $the_post->delete();
        
        return to_route('board.index');
    }

    //検索ワードセッション保存処理
    public function session(StoreTextRequest $request)
    {   
        $validated = $request->validated();
        $search = $request->input('text');
        session(['search' => $search]);

        return redirect()->route('board.search');
    }

    //検索表示ページ
    public function search()
    {   
        Paginator::useBootstrap();
        $id = Auth::user()->id;
        $posts_reverse = null;

        // 検索フォームで入力された値を取得する
        $search = session('search');
        $search_posts = null; //検索結果を入れる
        $query = Post::query();
        // もし検索フォームにキーワードが入力されたら
        if ($search) {

            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');

            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('text', 'like', '%'.$value.'%');
            }
            
            // 上記の$queryをページネートで、変数$search_postsに代入
            $search_posts = $query->orderBy("created_at", "desc")->paginate(20);
        }

        //ブックマーク機能
        $bookmarks = Bookmark::select('post_id')->where('user_id', '=', $id)->get();

        $post_id = array();
        foreach($bookmarks as $bookmark){
            array_push($post_id, $bookmark->post_id);
        }

        $search_cnt = 1; //検索されたか判定

        return view('users.boards.board', [
            'id' => $id,
            'posts_reverse' => $posts_reverse,
            'search_posts' => $search_posts,
            'search_cnt' => $search_cnt,
            'post_id' => $post_id,
        ]);
    }

    //検索後投稿削除処理
    public function searchDestroy(Request $request)
    {   
        $the_post_id = $request->post_id;

        $the_post = Post::find($the_post_id);
        $bookmark = Bookmark::where('post_id', $the_post_id);

        $bookmark->delete();
        $the_post->delete();
        
        return to_route('board.search');
    }

    //ブックマーク登録処理
    public function bookmark(Request $request)
    {   
        $user_id = Auth::user()->id;
        $the_post_id = $request->post_id;

        $bookmark = array('user_id' => $user_id, 'post_id' => $the_post_id);
        
        Bookmark::create($bookmark);

        return to_route('board.index');
    }

    //検索後ブックマーク登録処理
    public function searchBookmark(Request $request)
    {   
        $user_id = Auth::user()->id;
        $the_post_id = $request->post_id;

        $bookmark = array('user_id' => $user_id, 'post_id' => $the_post_id);
        
        Bookmark::create($bookmark);

        return to_route('board.search');
    }

    //ブックマーク削除処理
    public function bookmarkDestroy(Request $request)
    {   
        $user_id = Auth::user()->id;
        $the_post_id = $request->post_id;

        Bookmark::where('user_id', $user_id)->where('post_id', $the_post_id)->delete();

        return to_route('board.index');
    }

    //検索後ブックマーク削除処理
    public function searchBookmarkDestroy(Request $request)
    {   
        $user_id = Auth::user()->id;
        $the_post_id = $request->post_id;

        Bookmark::where('user_id', $user_id)->where('post_id', $the_post_id)->delete();

        return to_route('board.search');
    }
    
    //画像投稿処理
    public function storeImage(StoreImageRequest $request)
    {
        $user_id = Auth::user()->id;
        $validated = $request->validated();
        
        //ファイル保存
        $filename=$request->file('image')->store('images', 'public');       //storageフォルダに投稿した画像を保存しファイルパスを格納
        $filename=str_replace('public/', '', $filename);
        $post = array();
        $post = array_merge($post, array('image' => $filename));
        $post = array_merge($post, array('user_id' => $user_id));

        Post::create($post);
        return to_route('board.index');
    }

    //個人ページ
    public function indivisual(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = $request->user_id;

        $the_user_name = User::where("id", $the_user_id)->value("name");

        $posts_reverse = Post::where("user_id", $the_user_id)->orderBy("created_at", "desc")->paginate(20);

        //検索結果画面に戻す必要があるか判定
        $search_cnt=0;

        return view('users.boards.indivisual', [
            'posts_reverse' => $posts_reverse,
            'name' => $the_user_name,
            'search_cnt' => $search_cnt,
        ]);
    }

    //検索後個人ページ
    public function searchIndivisual(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = $request->user_id;

        $the_user_name = User::where("id", $the_user_id)->value("name");

        $posts_reverse = Post::where("user_id", $the_user_id)->orderBy("created_at", "desc")->paginate(20);

        //検索結果画面に戻す必要があるか判定
        $search_cnt=1;

        return view('users.boards.indivisual', [
            'posts_reverse' => $posts_reverse,
            'name' => $the_user_name,
            'search_cnt' => $search_cnt,
        ]);
    }
}