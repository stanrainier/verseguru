<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->string('verse_text')->nullable()->change();
            $table->string('book_id')->nullable()->change();
            $table->string('chapter')->nullable()->change();
            $table->string('verse')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            // Revert the changes if needed (you can remove this if you don't need it)
            // $table->string('verse_text')->change();
            // $table->string('book_id')->change();
            // $table->integer('chapter')->change();
            // $table->integer('verse')->change();
        });
    }
    
};
