<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id('id');
            $table->string('user_name')->nullable(true);
//            $table->string('email')->unique();

//            $table->string('password');
//            $table->rememberToken();
            $table->string('mobile1',30)->nullable(true);
            $table->string('mobile2',30)->nullable(true);

            $table->bigInteger('user_type_id')->unsigned();
            $table ->foreign('user_type_id')->references('id')->on('user_types');

            $table->bigInteger('customer_category_id')->unsigned()->default(2);
            $table ->foreign('customer_category_id')->references('id')->on('customer_categories');

            //Address
            $table->String('address1', 100)->nullable(true);
            $table->String('address2', 100)->nullable(true);
            $table->String('state', 50)->default('West Bengal')->nullable(true);
            $table->String('po', 50)->nullable(true);
            $table->String('area', 50)->nullable(true);
            $table->String('city', 50)->nullable(true);
            $table->String('pin', 30)->nullable(true);
            $table->double('mv')->default(0);

            $table->double('opening_balance_LC')->default(0);
            $table->double('opening_balance_Gold')->default(0);
            $table->double('discount')->default(0);

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
        Schema::dropIfExists('people');
    }
}
