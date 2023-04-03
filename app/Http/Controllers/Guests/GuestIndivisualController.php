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
    //ゲスト掲示板
    public function index(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = $request->user_id;

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


    //ゲスト掲示板
    public function search(Request $request)
    {   
        Paginator::useBootstrap();

        $the_user_id = $request->user_id;

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
