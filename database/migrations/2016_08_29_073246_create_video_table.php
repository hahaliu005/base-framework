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
            $table->integer('user_id')->unsigned()->comment('发布者ID');
            $table->string('title')->comment('标题');
            $table->string('sub_title')->comment('副标题');
            $table->integer('size')->unsigned()->comment('视频大小, 单位KB');
            $table->integer('duration')->unsigned()->comment('播放时长, 单位秒');
            $table->integer('play_count')->comment('播放次数');
            $table->tinyInteger('status')->default(\App\Video::STATUS_UPLOADING)->comment('视频当前状态');
            $table->text('file_name')->comment('视频文件名');
            $table->text('description')->comment('描述');
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
