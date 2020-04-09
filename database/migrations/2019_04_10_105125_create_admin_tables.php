<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 128)->unique();
            $table->string('userid', 128)->default('');
            $table->string('password', 128)->default('');
            $table->string('password_org', 128)->default('');
            $table->rememberToken();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // 管理者用連絡
        Schema::create('admin_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('notify_type')->default(0);  // １：歌 , ２：漫才
            $table->datetime('notify_date')->nullable();  // お知らせ日時
            $table->text('message')->nullable();  // 内容
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->index(['notify_type'], 'idx_1');
            $table->index(['notify_date'], 'idx_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
        Schema::dropIfExists('admin_infos');
    }
}