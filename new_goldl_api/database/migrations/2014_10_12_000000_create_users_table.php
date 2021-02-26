<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id');
            $table->string('user_name')->nullable(true);
            $table->string('email')->unique();

            $table->string('password');
            $table->rememberToken();
            $table->string('mobile1',15)->nullable(true);
            $table->string('mobile2',15)->nullable(true);

            $table->bigInteger('user_type_id')->unsigned()->default(2);
            $table ->foreign('user_type_id')->references('id')->on('user_types');
            $table->tinyInteger('inforce')->default(1);
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
        Schema::dropIfExists('users');
    }
}
