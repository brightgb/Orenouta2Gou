<?php

/** 俺の歌を育てろ（管理）**/
// ログイン
Route::get('login', function() { return view('admin_auth.login'); })->name('admin.auth.login');
Route::post('login', 'Auth\LoginController@login')->name('admin.auth.login');

Route::middleware('auth:admin')->group(function() {
// トップ画面
Route::get('/', function() { return view('admin.index'); })->name('index');

/* 歌唱曲管理 */
// 歌唱曲一覧
Route::get('song_list', 'Admin\SongController@index1')->name('admin.song.list.index');
Route::post('song_list', 'Admin\SongController@getList')->name('admin.song.get.list');
// コメント一覧
Route::get('comment_list', 'Admin\SongController@index2')->name('admin.comment.index');
Route::post('comment_list', 'Admin\SongController@getComment')->name('admin.get.comment');
Route::post('comment_delete', 'Admin\SongController@deleteComment')->name('admin.delete.comment');
// 歌唱曲の投稿
Route::get('song_post', 'Admin\SongController@addSong')->name('admin.song.post');
Route::post('song_post', 'Admin\SongController@addList')->name('admin.list.post');

/* おまけ管理 */

/* 管理者権限 */
// お問い合わせ・要望
Route::get('request_list', 'Admin\ManagementController@index1')->name('admin.request.list.index');
Route::post('request_list', 'Admin\ManagementController@getList')->name('admin.request.get.list');
Route::post('request/accept', 'Admin\ManagementController@accept')->name('admin.request.accept');
Route::post('request/reject', 'Admin\ManagementController@reject')->name('admin.request.reject');
Route::post('request/back', 'Admin\ManagementController@back')->name('admin.request.back');
Route::post('request/delete', 'Admin\ManagementController@delete')->name('admin.request.delete');
// 新着情報
Route::get('infomation', 'Admin\ManagementController@index2')->name('admin.info.index');
Route::post('infomation', 'Admin\ManagementController@getInfo')->name('admin.get.info');
Route::post('add_info', 'Admin\ManagementController@addInfo')->name('admin.post.info');
Route::post('delete_info', 'Admin\ManagementController@deleteInfo')->name('admin.delete.info');
// パスワード変更
Route::get('account', 'Admin\ManagementController@index3')->name('admin.account.index');
Route::get('account/create', 'Admin\ManagementController@createAccount')->name('admin.account.create');
Route::post('account/store', 'Admin\ManagementController@storeAccount')->name('admin.account.store');
Route::get('account/edit/{id}', 'Admin\ManagementController@editAccount')->name('admin.account.edit');
Route::post('account/update', 'Admin\ManagementController@updateAccount')->name('admin.account.update');
Route::post('account/delete', 'Admin\ManagementController@deleteAccount')->name('admin.account.delete');

// ログアウト
Route::get('logout', 'Auth\LoginController@logout')->name('admin.auth.logout');
});