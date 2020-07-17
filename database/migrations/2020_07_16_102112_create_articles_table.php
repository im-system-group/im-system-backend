<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('author_id')->comment('作者ID');
            $table->text('title')->comment('標題');
            $table->text('content')->comment('文章內容');
            $table->string('image')->nullable()->comment('文章圖片');
            $table->json('like_info')->comment('按讚紀錄');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
