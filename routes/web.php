<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** 俺の歌を育てろ（ユーザー）**/
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

// おまけメニュー
Route::get('/caster_board', function() { return view('errors.creating'); });
Route::get('/rubber_shot', function() { return view('errors.creating'); });
Route::get('/dj_play', function() { return view('errors.creating'); });

// お問い合わせ・要望
Route::get('/request', 'User\IndexController@requestForm')->name('my_song.request.form');
Route::post('/request', 'User\IndexController@requestPost')->name('my_song.request.post');
Route::get('/about_request', 'User\IndexController@requestAbout')->name('my_song.request.about');

// 画像アップロード用テスト
Route::post('/index', 'TestController@upload')->name('test.upload');
Route::name('storage::')->group(function() {
    /*Noイメージ
    Route::get('/storage/image/{file}', 'ImageController@noImage');
    会員プロフィール画像表示
    Route::get('/storage/image/member/profile/{year}/{mday}/{file}', 'ImageController@memberProfileImage');
    女性無料画像表示
    Route::get('/storage/image/performer/profile/{year}/{mday}/{file}', 'ImageController@performerProfileImage');
    女性有料画像表示(モザイクあり)
    Route::get('/storage/image/performer/premium/{year}/{mday}/{file}', 'ImageController@performerPremiumImage');*/
});