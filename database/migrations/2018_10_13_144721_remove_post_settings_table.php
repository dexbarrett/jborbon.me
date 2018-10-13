<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePostSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::drop('post_settings');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('post_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enable_comments')->default(false);
            $table->integer('post_id')->unsigned()->references('id')->on('posts');
            $table->timestamps();
        });
    }
}
