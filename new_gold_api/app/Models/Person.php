<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        "inforce","created_at","updated_at", 'remember_token',
    ];
    protected $visible = ['id',
        'user_name',
        'billing_name',
        'email',
        'mobile1',
        'mobile2',
        'customer_category_id',
        'user_type_id',
        'address1',
        'address2',
        'state',
        'city',
        'po',
        'area',
        'pin',
        'opening_balance_LC',
        'opening_balance_Gold',
        'mv',
        'discount'
        ];

    public function userData(){
        return $this->hasOne('App\Models\Person','id');
    }



}
