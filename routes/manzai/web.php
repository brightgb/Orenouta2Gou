<?php
Route::get('login', function() { return view('_auth.login'); })->name('admin.auth.login');
Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.auth.login');

// トップ画面
Route::get('/', 'User\IndexController@index')->name('my_song.index');
// 新着情報
Route::get('/info', 'User\IndexController@info')->name('my_song.info');
// サイトについて
Route::get('/about_site', 'User\IndexController@help')->name('my_song.help');
// 管理人プロフィール
Route::get('/profile', 'User\IndexController@profile')->name('my_song.profile');
// 投稿した歌唱曲一覧
Route::get('/song_list', 'User\SongController@songList')->name('my_song.song_list');
// 投稿した歌唱曲詳細
Route::get('/song_detail/{id}', 'User\SongController@songDetail')->name('my_song.detail');
Route::post('/song_advice/post', 'User\SongController@post')->name('my_song.post');

// お問い合わせ・要望
Route::get('/request', 'User\IndexController@requestForm')->name('my_song.request.form');
Route::post('/request', 'User\IndexController@requestPost')->name('my_song.request.post');
Route::get('/about_request', 'User\IndexController@requestAbout')->name('my_song.request.about');