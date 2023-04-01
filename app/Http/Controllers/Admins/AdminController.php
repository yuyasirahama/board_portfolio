<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class AdminController extends Controller
{
    //管理者ログインページ
    public function LoginForm()
    {
        return view('admins.login');
    }

    //管理者アカウント作成ページ
    public function create()
    {
        return view('admins.create');
    }

    //管理者アカウント作成処理
    public function store(StoreAdminRequest $request)
    {   
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        Admin::create($validated);

        return to_route('admin.loginForm');
    }

    //管理者ページ
    public function index()
    {
        return view('admins.admin');
    }
}
