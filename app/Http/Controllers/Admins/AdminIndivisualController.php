<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use App\Models\Post;
use App\Models\User;
use App\Models\Bookmark;

class AdminIndivisualController extends Controller
{   
    //個人user_idセッション保存
    public function session(Request $request)
    {   
        $user_id = $request->user_id;
        session(['user_id' => $user_id]);

        return redirect()->route('admin.indivisual');
    }

    //管理者個人ページ
    public function index()
    {   
        Paginator::useBootstrap();

        $the_user_id = session('user_id');

        $the_user_name = User::where("id", $the_user_id)->value("name");

        $posts_reverse = Post::where("user_id", $the_user_id)->orderBy("created_at", "desc")->paginate(20);

        return view('admins.indivisual', [
            'posts_reverse' => $posts_reverse,
            'name' => $the_user_name,
        ]);
    }

    //投稿削除処理
    public function destroy(Request $request)
    {   
        $the_post_id = $request->post_id;

        $the_post = Post::find($the_post_id);
        $bookmark = Bookmark::where('post_id', $the_post_id);

        $bookmark->delete();
        $the_post->delete();
        
        return to_route('admin.indivisual');
    }
}
