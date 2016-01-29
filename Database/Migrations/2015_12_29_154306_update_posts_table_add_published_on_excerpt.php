<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePostsTableAddPublishedOnExcerpt extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog__posts', function(Blueprint $table)
        {
            $table->timestamp('published_on')->after('status')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::table('blog__post_translations', function(Blueprint $table)
        {
            $table->text('excerpt')->after('content')->nullable();
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
            $table->dropColumn('published_on');
        });

        Schema::table('blog__post_translations', function(Blueprint $table)
        {
            $table->dropColumn('excerpt');
        });
    }
}
