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
//            $table->string('user_name')->nullable(true);
            $table->string('email')->unique();

            $table->string('password');
            $table->rememberToken();
//            $table->string('mobile1',15)->nullable(true);
//            $table->string('mobile2',15)->nullable(true);
//
//            $table->bigInteger('user_type_id')->unsigned();
//            $table ->foreign('user_type_id')->references('id')->on('user_types');

            $table->bigInteger('person_id')->unsigned();
            $table ->foreign('person_id')->references('id')->on('people');

            //Address
//            $table->String('address1', 100)->nullable(true);
//            $table->String('address2', 100)->nullable(true);
//            $table->String('state', 50)->default('West Bengal')->nullable(true);
//            $table->String('po', 50)->nullable(true);
//            $table->String('area', 50)->nullable(true);
//            $table->String('city', 50)->nullable(true);
//            $table->String('pin', 10)->nullable(true);
//            $table->double('mv')->default(0);
//
//            $table->double('opening_balance_LC')->default(0);
//            $table->double('opening_balance_Gold')->default(0);
//            $table->double('discount')->default(0);

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
