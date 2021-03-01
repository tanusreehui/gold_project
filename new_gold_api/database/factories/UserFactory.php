<?php

namespace Database\Factories;
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CustomerCategory;

$factory->define(User::class, function (Faker $faker) {
    return [
        'user_name'=>$faker->name,
        'mobile1'=>$faker->randomNumber($nbDigits = 5, $strict = true).$faker->randomNumber($nbDigits = 5, $strict = true),
        'mobile2'=>$faker->randomNumber($nbDigits = 5, $strict = true).$faker->randomNumber($nbDigits = 5, $strict = true),
        'email'=>$faker->email,
        'password'=> '81dc9bdb52d04dc20036dbd8313ed055',
        'user_type_id'=>10,

        'address1'=>$faker->address,
        'address2'=>$faker->secondaryAddress,
        'state'=>'West Bengal',
        'po'=>$faker->streetName,
        'area'=>$faker->cityPrefix,
        'city'=>$faker->city,
        'pin'=>$faker->postcode,
        'mv'=>0.111,
        'discount'=>10,


        'customer_category_id'=>function(){
            return CustomerCategory::all()->where('id','>',1)->random();
        },
    ];
});


