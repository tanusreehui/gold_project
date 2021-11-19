<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
             Person::create(['user_name'=>'Angana Jewellers', 'billing_name'=>'M/s Angana Jewellers', 'mobile1'=>'9831397484', 'mobile2'=>'546546464', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
             Person::create(['user_name'=>'Milan Kanak Sanj Jewellers', 'billing_name'=>'M/s Milan Kanak Sanj Jewellers', 'mobile1'=>'943382305', 'mobile2'=>'24338894', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
    }
}
