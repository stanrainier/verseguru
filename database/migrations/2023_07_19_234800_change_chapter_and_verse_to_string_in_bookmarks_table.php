<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeChapterAndVerseToStringInBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->string('chapter')->nullable()->change();
            $table->string('verse')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            // If you need to revert the changes, you can do it here
            // For example, if the original data type was integer
            // $table->integer('chapter')->change();
            // $table->integer('verse')->change();
        });
    }
}
