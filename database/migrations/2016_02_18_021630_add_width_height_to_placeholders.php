<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWidthHeightToPlaceholders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placeholders', function (Blueprint $table) {
          $table->string('width')->after('thumbnail_path');
          $table->string('height')->after('thumbnail_path');
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
          $table->dropColumn('width');
          $table->dropColumn('height');
        });
    }
}
