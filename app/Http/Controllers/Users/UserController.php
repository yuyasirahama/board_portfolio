<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{   
    //ユーザーページ
    public function index()
    {
        return view('users.users.user');
    }

    //ユーザーネーム変更
    public function update(UpdateUserRequest $request)
    {   
        $validated = $request->validated();
        $id = Auth::user()->id;
        
        User::where('id', $id)->update(['name' => $validated['name']]);

        return to_route('user.index');
    }
}
