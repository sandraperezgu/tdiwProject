<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_post', function (Blueprint $table) {

            $table->timestamps();
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('post_id');
            $table->primary(['tag_id','post_id']);
            $table->foreign('tag_id')->references('id')->on('tag');
            $table->foreign('post_id')->references('id')->on('post');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_post');
    }
}
