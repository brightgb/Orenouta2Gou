<?php
/* ログインなしで見れるページ */
// トップ画面
Route::get('/', 'Song\IndexController@index')->name('song.index');
// 新着情報
Route::get('/info', 'Song\IndexController@info')->name('song.info');
// サイトについて
Route::get('/about_site', 'Song\IndexController@help')->name('song.help');
// 会員登録
Route::get('/regist', 'Song\IndexController@registForm')->name('song.regist.form');
Route::get('/regist/success', 'Song\IndexController@registSuccess')->name('song.regist.success');

Route::get('/login', 'Song\Auth\LoginController@showLoginForm')->name('song.auth.login');
Route::post('/login', 'Song\Auth\LoginController@login')->name('song.auth.login');

/* ログイン後 */
Route::middleware('auth:song')->group(function() {
Route::middleware('checkSongMemberStat')->group(function() {
// アカウント確認（マイメニュー）
Route::get('/my_account', 'Song\AccountController@index')->name('song.account.index');
// アカウント確認（パスワード更新）
Route::post('/my_account', 'Song\AccountController@changePass')->name('song.account.changepass');
// 自分の過去投稿曲（一覧）
Route::get('/account/my_song', 'Song\AccountController@songList')->name('account.song.list');
// 自分の過去投稿曲（詳細）
Route::get('/account/my_song_detail/{song_id}', 'Song\AccountController@songDetail')->name('account.song.detail');
// 歌唱曲の投稿
Route::get('/account/sing_song', 'Song\AccountController@singForm')->name('sing.song.form');
Route::post('/account/sing_song', 'Song\AccountController@singSong')->name('sing.song.post');
// お気に入り登録リスト
Route::get('/my_favorite', 'Song\AccountController@getMyFavorite')->name('account.my.favorite');
// 退会
Route::get('/account/resign', 'Song\AccountController@resignForm')->name('song.resign.form');
Route::post('/account/resign', 'Song\AccountController@resignComplete')->name('song.resign.post');

// 他の会員が投稿した歌唱曲一覧
Route::get('/song_search', 'Song\SongController@songSearchForm')->name('song.search.form');
Route::post('/song_search', 'Song\SongController@songSearchPost')->name('song.search.post');
Route::get('/song_list', 'Song\SongController@songList')->name('song.song_list');
// 他の会員が投稿した歌唱曲詳細
Route::get('/song_detail/{song_id}', 'Song\SongController@songDetail')->name('song.detail');
Route::post('/song_advice/post', 'Song\SongController@post')->name('song.post');

// お問い合わせ・要望
Route::get('/request', 'Song\IndexController@requestForm')->name('song.request.form');
Route::post('/request', 'Song\IndexController@requestPost')->name('song.request.post');
Route::get('/about_request', 'Song\IndexController@requestAbout')->name('song.request.about');

// ログアウト
Route::get('/logout', 'Song\Auth\LoginController@logout')->name('song.auth.logout');
});
});