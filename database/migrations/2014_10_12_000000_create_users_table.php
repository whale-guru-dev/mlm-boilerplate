<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('family_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('profile_photo')->nullable();
            $table->string('password', 60);
            $table->integer('mobile');
            $table->integer('status')->default(1);
            $table->string('qr_pass')->nullable();
            $table->string('qr_path')->nullable();
            $table->string('refer_link')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
