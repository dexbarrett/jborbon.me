<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('markdown_content');
            $table->text('html_content');
            $table->string('slug');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->integer('post_category_id')->unsigned()->references('id')->on('post_categories');
            $table->integer('post_type_id')->unsigned()->references('id')->on('post_types');
            $table->integer('post_status_id')->unsigned()->references('id')->on('post_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
