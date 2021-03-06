<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $hidden = [
        "inforce","created_at","updated_at",'password', 'remember_token',
    ];
    protected $visible = ['id',
        'user_name',
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
        'discount'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userData(){
          return $this->hasOne('App\Models\Person','id');
    }

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}
