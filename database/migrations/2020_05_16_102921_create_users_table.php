<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->default(0)->comment('角色ID');
            $table->string('username',50)->comment('账号');
            $table->string('truename',20)->default('未知')->comment('真是姓名');
            $table->string('password',255)->comment('密码');
            $table->string('email',50)->default('')->comment('邮箱');
            $table->string('phone',20)->comment('手机');
            $table->enum('sex',['先生','女士'])->default('先生')->comment('性别');
            $table->char('last_ip',15)->default('')->comment('登录IP');
            $table->timestamps();
            //软删除
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
