<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{   
    //管理者ログイン
    public function AdminLogin(Request $request)
    {
        // バリデーション(フォームリクエストに書き換え可)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // ログイン情報が正しいか
        // Auth::attemptメソッドでログイン情報が正しいか検証
        if (Auth::guard('admin')->attempt($credentials)) {
            // セッションを再生成する処理(セキュリティ対策)
            $request->session()->regenerate();
    
            // ミドルウェアに対応したリダイレクト(後述)
            // 下記はredirect('/admin/blogs')に類似
            return redirect()->intended(route('admin.admin'));
        }
    
        // ログイン情報が正しくない場合のみ実行される処理(return すると以降の処理は実行されないため)
        // 一つ前のページ(ログイン画面)にリダイレクト
        // その際にwithErrorsを使ってエラーメッセージで手動で指定する
        // リダイレクト後のビュー内でold関数によって直前の入力内容を取得出来る項目をonlyInputで指定する
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }

    //管理者ログアウト
    public function AdminLogout(Request $request)
    {
        // ログアウト処理
        Auth::logout();
        // 現在使っているセッションを無効化(セキュリティ対策のため)
        $request->session()->invalidate();
        // セッションを無効化を再生成(セキュリティ対策のため)
        $request->session()->regenerateToken();
    
        return redirect()->route('admin.loginForm');
    }
}
