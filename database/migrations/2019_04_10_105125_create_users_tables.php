<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 投稿した歌唱曲一覧
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128)->default('');  // タイトル
            $table->string('file_name', 128)->default('');  // 動画ファイル名
            $table->text('comment')->nullable();  // 管理人のコメント
            $table->integer('advice_cnt')->default(0);  // 書き込み件数
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // 曲に対するアドバイス一覧
        Schema::create('advice_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('song_id')->default(0);  // 曲リストのid
            $table->text('advice')->nullable();  // アドバイスの内容
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // お問い合わせ・要望
        Schema::create('user_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question')->nullable();  // 内容
            $table->integer('status')->default(0);  // ０：未対応 , １：対応予定 , ２：却下
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // 管理者用連絡
        Schema::create('admin_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('notify_date')->nullable();  // お知らせ日時
            $table->text('message')->nullable();  // 内容
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // 画像アップ用
        Schema::create('profile_imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 128)->default('');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_imgs');
        Schema::dropIfExists('songs');
        Schema::dropIfExists('advice_lists');
        Schema::dropIfExists('user_questions');
        Schema::dropIfExists('admin_infos');
    }
}