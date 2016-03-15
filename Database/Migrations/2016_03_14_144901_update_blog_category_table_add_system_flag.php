<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogCategoryTableAddSystemFlag extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog__categories', function(Blueprint $table)
        {
            $table->boolean('on_backend')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog__categories', function(Blueprint $table)
        {
            $table->dropColumn('on_backend');
        });
    }

}
