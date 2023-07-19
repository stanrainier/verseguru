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
            // Option 1: Set a default value for 'verse_text' column
            $table->string('verse_text')->default('')->change();
    
            // Option 2: Allow 'verse_text' column to be nullable
            // $table->string('verse_text')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            // Revert the changes if needed (you can remove this if you don't need it)
            // $table->string('verse_text')->change();
        });
    }
    
};
