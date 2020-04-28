<?php

/** 管理画面 **/
// ログイン
Route::get('login', function() { return view('admin_auth.login'); })->name('admin.auth.login');
Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.auth.login');

Route::middleware('auth:admin')->group(function() {
// トップ画面
Route::get('/', function() { return view('admin.index'); })->name('index');

/* 俺の歌を育てろ */
// 会員検索
Route::get('/orenouta/user_search', 'Admin\SongUserController@index1')
     ->name('admin.song.user.index1');
Route::post('/orenouta/user_search', 'Admin\SongUserController@search')
     ->name('admin.song.user.search');
// 会員詳細
Route::get('/orenouta/user_detail', 'Admin\SongUserController@index2')
     ->name('admin.song.user.index2');
Route::post('/orenouta/user_detail', 'Admin\SongUserController@detail')
     ->name('admin.song.user.detail');
// 歌唱曲一覧
Route::get('/orenouta/song_list', 'Admin\SongUserController@index3')
     ->name('admin.song.list.index');
Route::post('/orenouta/song_list', 'Admin\SongUserController@getList')
     ->name('admin.song.list.get');
// コメント一覧
Route::get('/orenouta/comment_list', 'Admin\SongUserController@index4')
     ->name('admin.song.comment.index');
Route::post('/orenouta/comment_list', 'Admin\SongUserController@getComment')
     ->name('admin.song.comment.get');
Route::post('/orenouta/comment_delete', 'Admin\SongUserController@deleteComment')
     ->name('admin.song.comment.delete');
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





/* 管理者権限 */
// パスワード変更
Route::get('account', 'Admin\ManagementController@index3')->name('admin.account.index');
Route::get('account/create', 'Admin\ManagementController@createAccount')->name('admin.account.create');
Route::post('account/store', 'Admin\ManagementController@storeAccount')->name('admin.account.store');
Route::get('account/edit/{id}', 'Admin\ManagementController@editAccount')->name('admin.account.edit');
Route::post('account/update', 'Admin\ManagementController@updateAccount')->name('admin.account.update');
Route::post('account/delete', 'Admin\ManagementController@deleteAccount')->name('admin.account.delete');

// ログアウト
Route::get('logout', 'Admin\Auth\LoginController@logout')->name('admin.auth.logout');
});