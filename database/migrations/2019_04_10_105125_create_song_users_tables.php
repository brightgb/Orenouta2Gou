<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateSongUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 歌部門に登録しているユーザー
        Schema::create('song_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname', 128)->default('');
            $table->string('userid', 128)->default('');
            $table->string('password', 128)->default('');
            $table->string('password_org', 128)->default('');
            $table->unsignedTinyInteger('singer_rank')->default(0);  // Config に定義
            $table->unsignedTinyInteger('advicer_rank')->default(0);  // Config に定義
            $table->unsignedTinyInteger('resign_flg')->default(0);  // １：退会済み
            $table->text('admin_memo')->nullable();  // ユーザーに関する備考
            $table->rememberToken();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->unique('nickname', 'uidx_1');
            $table->unique('userid', 'uidx_2');
        });

        // ユーザーが投稿した歌唱曲とアドバイスの記録
        Schema::create('song_user_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->default(0);
            $table->unsignedBigInteger('get_advice_cnt')->default(0);
            $table->unsignedBigInteger('sing_song_cnt')->default(0);
            $table->unsignedBigInteger('get_nice_cnt')->default(0);
            $table->unsignedBigInteger('all_advice_cnt')->default(0);
            $table->unsignedBigInteger('get_favorite_cnt')->default(0);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->unique(['member_id'], 'uidx_1');
            $table->index(['member_id'], 'idx_1');
        });

        // 投稿した歌唱曲一覧
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->default(0);  // 投稿者
            $table->string('title', 128)->default('');  // タイトル
            $table->string('file_name', 128)->default('');  // 動画ファイル名
            $table->text('comment')->nullable();  // 投稿者のコメント
            $table->unsignedBigInteger('advice_cnt')->default(0);  // アドバイス件数
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->index(['member_id'], 'idx_1');
        });

        // 曲に対するアドバイス一覧
        Schema::create('song_advice_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('song_id')->default(0);  // 曲リストのid
            $table->unsignedBigInteger('member_id')->default(0);  // アドバイザー
            $table->text('advice')->nullable();  // アドバイスの内容
            $table->unsignedTinyInteger('nice_flg')->default(0);  // １：役に立ったアドバイス認定
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->unique(['song_id', 'member_id'], 'uidx_1');
            $table->index(['song_id'], 'idx_1');
            $table->index(['member_id'], 'idx_2');
            $table->index(['song_id', 'member_id'], 'idx_3');
        });

        // お気に入り登録リスト
        Schema::create('song_user_favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->default(0);  // 登録した会員id
            $table->unsignedBigInteger('target_id')->default(0);  // 対象の会員id
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->index(['member_id'], 'idx_1');
            $table->index(['target_id'], 'idx_2');
        });

        // お問い合わせ・要望
        Schema::create('song_user_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->default(0);
            $table->text('question')->nullable();  // 内容
            $table->integer('status')->default(0);  // ０：未対応 , １：対応(予定 or 済) , ２：却下
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->index(['member_id'], 'idx_1');
            $table->index(['status'], 'idx_2');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_users');
        Schema::dropIfExists('song_user_actions');
        Schema::dropIfExists('songs');
        Schema::dropIfExists('song_advice_lists');
        Schema::dropIfExists('song_user_favorites');
        Schema::dropIfExists('song_user_questions');
    }
}