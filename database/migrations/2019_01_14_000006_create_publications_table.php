<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->string('media');
            $table->integer('user_id')->unsigned();
            $table->integer('spot_id')->unsigned()->nullable(true);
            $table->timestamps();
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->foreign('spot_id')->references('id')->on('spots');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
