<?php
Route::post('/api/regist', 'Song\IndexController@registPost')->name('song.api.regist');

/* ログイン後 */
Route::middleware('auth:song')->group(function() {
    Route::post('/api/send_nice', 'Song\AccountController@sendNice')->name('advice.api.nice');
    Route::post('/api/fav_switch', 'Song\SongController@favoriteSwitch')->name('fav.api.nice');
    Route::post('/api/fav_remove', 'Song\AccountController@favoriteRemove')->name('fav.api.remove');
});