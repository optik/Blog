<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog__posts', function(Blueprint $table)
        {
            $table->integer('author_id')->after('status')->unsigned()->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog__posts', function(Blueprint $table)
        {
            $table->dropColumn('author_id');
        });
    }

}
