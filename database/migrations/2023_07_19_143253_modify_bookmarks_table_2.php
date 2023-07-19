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
            // Option 1: Set a default value for 'book_id' column
            $table->string('book_id')->default('')->change();
    
            // Option 2: Allow 'book_id' column to be nullable
            // $table->string('book_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            // Revert the changes if needed (you can remove this if you don't need it)
            // $table->string('book_id')->change();
        });
    }
};
