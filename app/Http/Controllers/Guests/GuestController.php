<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StoreTextRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GuestController extends Controller
{
    //ゲスト掲示板
    public function index()
    {   
        Paginator::useBootstrap();

        $posts = new Post();
        $posts_reverse = $posts->orderBy("created_at", "desc")->paginate(20);

        //検索結果画面か否か判定
        $search_cnt=0;

        return view('guests.board', [
            'posts_reverse' => $posts_reverse,
            'search_cnt' => $search_cnt,
        ]);
    }

    //検索表示ページ
    public function search()
    {   
        Paginator::useBootstrap();
        $posts_reverse = null;

        // 検索フォームで入力された値を取得する
        $search_cnt = 1; //検索されたか判定
        $search_posts = null; //検索結果を入れる
        $search = session('search');
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
            
            // 上記で取得した$queryをページネートにし、変数$search_postsに代入
            $search_posts = $query->orderBy("created_at", "desc")->paginate(20);
        }
        
        return view('guests.board', [
            'posts_reverse' => $posts_reverse,
            'search_posts' => $search_posts,
            'search_cnt' => $search_cnt,
        ]);
    }

    //ゲスト検索ワードセッション保存
    public function session(StoreTextRequest $request)
    {   
        $validated = $request->validated();
        $search = $request->input('text');
        session(['search' => $search]);

        return redirect()->route('guest.search');
    }

    //ユーザー作成ページ
    public function create()
    {
        return view('guests.create');
    }

    //ユーザー作成処理
    public function store(StoreUserRequest $request)
    {   
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return to_route('user.auth');
    }

    //管理者ログインページ
    public function admin()
    {   
        return view('guests.admin');
    }
}