<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->comment('发布者ID');
            $table->string('title')->default('')->comment('标题');
            $table->string('sub_title')->default('')->comment('副标题');
            $table->integer('size')->unsigned()->default(0)->comment('视频大小, 单位KB');
            $table->integer('duration')->unsigned()->default(0)->comment('播放时长, 单位秒');
            $table->integer('play_count')->unsigned()->default(0)->comment('播放次数');
            $table->tinyInteger('status')->default(\App\Video::STATUS_UPLOADING)->comment('视频当前状态');
            $table->string('file_name')->comment('视频文件名');
            $table->text('description')->nullable()->comment('描述');
            $table->timestamp('released_at')->comment('发布时间');
            $table->timestamps();
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
        Schema::dropIfExists('videos');
    }
}