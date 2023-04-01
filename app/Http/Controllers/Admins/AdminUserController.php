<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Post;
use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Auth;

class AdminUserController extends Controller
{   
    //ユーザー管理ページ
    public function index()
    {
        Paginator::useBootstrap();

        $users = new User();
        $users_reverse = $users->orderBy("created_at", "desc")->paginate(20);

        $search_posts=null;
        $search_cnt=0;

        return view('admins.user', [
            'users_reverse' => $users_reverse,
        ]);
    }

    //ユーザー削除処理
    public function delete(Request $request)
    {   
        $user_id = $request->user_id;

        $user = User::find($user_id);

        $user->delete();
        
        return to_route('admin.index');
    }
}