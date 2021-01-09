<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();


            $table->string('name',50)->comment('节点名称');
            $table->string('route_name',100)->nullable()->default('')->comment('路由别名，权限认证标识');
            $table->unsignedInteger('pid')->default(0)->comment('上级ID');
            $table->enum('is_menu',['0','1'])->default(0)->comment('是否菜单，0否1是');

            $table->timestamps();
            //ruanshanchu
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
        Schema::dropIfExists('nodes');
    }
}
