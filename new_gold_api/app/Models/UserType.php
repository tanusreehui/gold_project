<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
//    public function people()
//    {
//        return $this->hasMany('App\Models\User','user_type_id');
//    }

    public function people()
    {
        return $this->hasMany('App\Models\Person','user_type_id');
    }

    public function customer()
    {
        return $this->hasMany('App\Models\Person','user_type_id')->where('customer_category_id','<',5);
    }


}
