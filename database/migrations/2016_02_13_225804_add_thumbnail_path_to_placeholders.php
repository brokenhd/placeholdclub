<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailPathToPlaceholders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placeholders', function (Blueprint $table) {
          $table->string('thumbnail_path')->after('path');
          $table->string('name')->after('thumbnail_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placeholders', function (Blueprint $table) {
          $table->dropColumn('thumbnail_path');
          $table->dropColumn('name');
        });
    }
}
