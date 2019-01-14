<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersFollowUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_follow_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_user_id')->unsigned();
            $table->integer('followed_user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('users_follow_users', function (Blueprint $table) {
            $table->foreign('follower_user_id')->references('id')->on('users');
            $table->foreign('followed_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_follow_users');
    }
}
