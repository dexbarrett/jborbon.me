<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugFieldToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->string('slug')->after('name');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropIndex('post_categories_slug_index');
            $table->dropColumn('slug');
        });
    }
}
