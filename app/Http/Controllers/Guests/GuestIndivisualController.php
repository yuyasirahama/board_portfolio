<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use App\Models\Post;
use App\Models\User;

class GuestIndivisualController extends Controller
{   
    //個人user_idセッション保存
    public function session(Request $request)
    {   
        $user_id = $request->user_id;
        session(['user_id' => $user_id]);

        return redirect()->route('guest.indivisual');
    }

    //ゲスト個人ページ
    public function index(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = session('user_id');

        $the_user_name = User::where("id", $the_user_id)->value("name");

        $posts_reverse = Post::where("user_id", $the_user_id)->orderBy("created_at", "desc")->paginate(20);

        //検索結果画面に戻す必要があるか判定
        $search_cnt=0;

        return view('guests.indivisual', [
            'posts_reverse' => $posts_reverse,
            'name' => $the_user_name,
            'search_cnt' => $search_cnt,
        ]);
    }
   
    //検索後個人user_idセッション保存
    public function searchSession(Request $request)
    {   
        $user_id = $request->user_id;
        session(['user_id' => $user_id]);

        return redirect()->route('guest.searchIndivisual');
    }

    //検索後ゲスト個人ページ
    public function search(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = session('user_id');

        $the_user_name = User::where("id", $the_user_id)->value("name");

        $posts_reverse = Post::where("user_id", $the_user_id)->orderBy("created_at", "desc")->paginate(20);

        //検索結果画面に戻す必要があるか判定
        $search_cnt=1;

        return view('guests.indivisual', [
            'posts_reverse' => $posts_reverse,
            'name' => $the_user_name,
            'search_cnt' => $search_cnt,
        ]);
    }
}
