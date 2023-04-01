<?php


use App\Http\Controllers\Guests\GuestController;
use App\Http\Controllers\Users\BoardController;
use App\Http\Controllers\Users\BookmarkController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admins\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [GuestController::class, 'index'])->name('guest.index')->middleware('guest'); //ゲスト掲示板

Route::middleware('guest')
->controller(GuestController::class)
->prefix('/guest')
->name('guest.')
->group(function() {
    Route::get('/', 'index')->name('index'); //ゲスト掲示板
    Route::post('/session', 'session')->name('session'); //検索ワードセッション保存
    Route::get('/search', 'search')->name('search'); //ゲスト掲示板検索結果表示
    Route::get('/user/create', 'create')->name('create'); //ユーザー作成ページ
    Route::post('/user/store', 'store')->name('store'); //ユーザー作成処理
});

Route::get('/user/auth', [AuthController::class, 'UserLoginForm'])->name('user.auth')->middleware('guest'); //ユーザーログインページ
Route::post('/user/login', [AuthController::class, 'UserLogin'])->name('user.login')->middleware('guest'); //ユーザーログイン
Route::post('/user/logout', [AuthController::class, 'UserLogout'])->name('user.logout')->middleware('auth'); //ユーザーログアウト

Route::middleware('auth')
->controller(BoardController::class)
->prefix('/board')
->name('board.')
->group(function() {
    Route::get('/', 'index')->name('index'); //掲示板
    Route::post('/store/text', 'storeText')->name('storeText'); //テキスト投稿
    Route::post('/store/image', 'storeImage')->name('storeImage'); //画像投稿
    Route::post('/session', 'session')->name('session'); //検索ワードセッション保存
    Route::get('/search', 'search')->name('search'); //検索結果表示
    Route::post('/destroy', 'destroy')->name('destroy'); //投稿削除
    Route::post('/search/destroy', 'searchDestroy')->name('searchDestroy'); //検索後投稿削除
    Route::post('/bookmark', 'bookmark')->name('bookmark'); //ブックマーク登録
    Route::post('/bookmark/destroy', 'bookmarkDestroy')->name('bookmarkDestroy'); //ブックマーク登録解除
    Route::post('/search/bookmark', 'searchBookmark')->name('searchBookmark'); //検索後ブックマーク登録
    Route::post('/search/bookmark/destroy', 'searchBookmarkDestroy')->name('searchBookmarkDestroy'); //検索後ブックマーク登録解除
});

Route::get('/bookmark', [BookmarkController::class, 'index'])->name('bookmark.index')->middleware('auth'); //ブックマークページ
Route::post('/bookmark/destroy', [BookmarkController::class, 'destroy'])->name('bookmark.destroy')->middleware('auth'); //呟きブックマーク削除
Route::post('/bookmark/bookmarkDestroy', [BookmarkController::class, 'bookmarkDestroy'])->name('bookmark.bookmarkDestroy')->middleware('auth'); //呟きブックマーク登録解除

Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('auth'); //ユーザーページ
Route::post('/user/update', [UserController::class, 'update'])->name('user.update')->middleware('auth'); //ユーザーページ


Route::get('/admin/auth', [AdminController::class, 'LoginForm'])->name('admin.loginForm')->middleware('guest:admin'); //管理者ログインページ
Route::post('/admin/login', [RegisterController::class, 'AdminLogin'])->name('admin.login')->middleware('guest:admin'); //管理者ログイン
Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create')->middleware('guest:admin'); //管理者アカウント作成ページ
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store')->middleware('guest:admin'); //管理者アカウント作成

Route::get('/admin/admin', [AdminController::class, 'index'])->name('admin.admin')->middleware('auth.admins:admin'); //管理者ページ
Route::post('/admin/logout', [RegisterController::class, 'AdminLogout'])->name('admin.logout')->middleware('auth.admins:admin'); //管理者ログアウト

Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.index')->middleware('auth.admins:admin'); //ユーザー管理ページ
Route::post('/admin/delete', [AdminUserController::class, 'delete'])->name('admin.delete')->middleware('auth.admins:admin'); //ユーザー削除処理



// Route::get('/guest/board', [GuestController::class, 'index'])->name('guest.index')->middleware('guest'); //ゲスト一覧表示用
// Route::post('/guest/session', [GuestController::class, 'session'])->name('guest.session')->middleware('guest'); //ゲスト検索セッション保存用
// Route::get('/guest/search', [GuestController::class, 'search'])->name('guest.search')->middleware('guest'); //ゲスト検索表示用
// Route::get('/guest/user', [GuestController::class, 'user'])->name('guest.user')->middleware('guest'); //ゲストユーザーページ
// Route::get('/guest/user/create', [GuestController::class, 'create'])->name('guest.create')->middleware('guest'); //ユーザー作成ページ
// Route::post('/guest/user/store', [GuestController::class, 'store'])->name('guest.store')->middleware('guest'); //ユーザー作成

// Route::get('/board', [BoardController::class, 'index'])->name('board.index')->middleware('auth'); //一覧表示用
// Route::post('/board/store/text', [BoardController::class, 'storeText'])->name('board.storeText')->middleware('auth'); //投稿保存
// Route::post('/board/store/image', [BoardController::class, 'storeImage'])->name('board.storeImage')->middleware('auth'); //イメージ保存
// Route::post('/board/session', [BoardController::class, 'session'])->name('board.session')->middleware('auth'); //ゲスト検索セッション保存用
// Route::get('/board/search', [BoardController::class, 'search'])->name('board.search'); //検索表示用
// Route::post('/board/destroy', [BoardController::class, 'destroy'])->name('board.destroy')->middleware('auth'); //呟き削除
// Route::post('/board/search/destroy', [BoardController::class, 'searchDestroy'])->name('board.searchDestroy')->middleware('auth'); //検索呟き削除
// Route::post('/board/bookmark', [BoardController::class, 'bookmark'])->name('board.bookmark')->middleware('auth'); //呟きブックマーク登録
// Route::post('/board/bookmark/destroy', [BoardController::class, 'bookmarkDestroy'])->name('board.bookmarkDestroy')->middleware('auth'); //呟きブックマーク登録解除
// Route::post('/board/search/bookmark', [BoardController::class, 'searchBookmark'])->name('board.searchBookmark')->middleware('auth'); //検索ブックマーク登録
// Route::post('/board/search/bookmark/destroy', [BoardController::class, 'searchBookmarkDestroy'])->name('board.searchBookmarkDestroy')->middleware('auth'); //検索ブックマーク登録解除
