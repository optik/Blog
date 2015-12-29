<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog__post_category', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->references('id')->on('blog__posts');
            $table->integer('post_id')->references('id')->on('blog__tags');
            $table->timestamps();
        });
        Schema::table('blog__posts', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog__post_category');
        Schema::table('blog__posts', function (Blueprint $table) {
            $table->integer('category_id')->index();
        });
    }

}
