<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('placeholders', function (Blueprint $table) {
        $table->increments('id');
        $table->string('path');
        $table->string('thumbnail_path');
        $table->string('name');

        $table->integer('club_id')->unsigned();
        $table->foreign('club_id')
          ->references('id')
          ->on('clubs')
          ->onUpdate('cascade')
          ->onDelete('cascade');

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('placeholders');
    }
}
