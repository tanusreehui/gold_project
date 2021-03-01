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
        return $this->hasMany('App\Models\Model\Person','user_type_id');
    }
}
