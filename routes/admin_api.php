<?php
/* ログイン後 */
Route::middleware('auth:admin')->group(function() {
    // 会員詳細（お気に入り登録リスト）
    Route::post('/api/orenouta/user_fav_list', 'Admin\SongUserController@favoriteList')
         ->name('admin.api.song.user.favorite');
});