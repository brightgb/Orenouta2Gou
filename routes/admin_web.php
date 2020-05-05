<?php

/*** 管理画面 ***/
// ログイン
Route::get('login', function() { return view('admin_auth.login'); })->name('admin.auth.login');
Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.auth.login');

Route::middleware('auth:admin')->group(function() {
// トップ画面
Route::get('/', function() { return view('admin.index'); })->name('index');

/****************************** 俺の歌を育てろ ******************************/
// 会員検索
Route::get('/orenouta/user_search', 'Admin\SongUserController@index1')
     ->name('admin.song.user.index1');
Route::post('/orenouta/user_search', 'Admin\SongUserController@search')
     ->name('admin.song.user.search');
// 会員詳細
Route::get('/orenouta/user_detail', 'Admin\SongUserController@detail')
     ->name('admin.song.user.detail');
Route::post('/orenouta/user_update', 'Admin\SongUserController@update')
     ->name('admin.song.user.update');
// 歌唱曲一覧
Route::get('/orenouta/song_list', 'Admin\SongUserController@index2')
     ->name('admin.song.list.index');
Route::post('/orenouta/song_list', 'Admin\SongUserController@getList')
     ->name('admin.song.list.get');
// アドバイス一覧
Route::get('/orenouta/comment_list', 'Admin\SongUserController@index3')
     ->name('admin.song.comment.index');
Route::post('/orenouta/comment_list', 'Admin\SongUserController@getComment')
     ->name('admin.song.comment.get');
Route::post('/orenouta/comment_delete', 'Admin\SongUserController@deleteComment')
     ->name('admin.song.comment.delete');
// お問い合わせ・要望
Route::get('/orenouta/request_list', 'Admin\SongManagementController@index1')
     ->name('admin.song.request.index');
Route::post('/orenouta/request_list', 'Admin\SongManagementController@getList')
     ->name('admin.song.request.get');
Route::post('/orenouta/request/accept', 'Admin\SongManagementController@accept')
     ->name('admin.song.request.accept');
Route::post('/orenouta/request/reject', 'Admin\SongManagementController@reject')
     ->name('admin.song.request.reject');
Route::post('/orenouta/request/complete', 'Admin\SongManagementController@complete')
     ->name('admin.song.request.complete');
Route::post('/orenouta/request/back', 'Admin\SongManagementController@back')
     ->name('admin.song.request.back');
Route::post('/orenouta/request/delete', 'Admin\SongManagementController@delete')
     ->name('admin.song.request.delete');
// 新着情報
Route::get('/orenouta/infomation', 'Admin\SongManagementController@index2')
     ->name('admin.song.info.index');
Route::post('/orenouta/infomation', 'Admin\SongManagementController@getInfo')
     ->name('admin.song.info.get');
Route::post('/orenouta/add_info', 'Admin\SongManagementController@addInfo')
     ->name('admin.song.info.post');
Route::post('/orenouta/delete_info', 'Admin\SongManagementController@deleteInfo')
     ->name('admin.song.info.delete');





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