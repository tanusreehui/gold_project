<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;
//    protected $dateFormat = 'U';

//    protected $casts = [
//        'created_at' => 'datetime:Y-m-d H:00',
//    ];

//    protected $appends = ['created_at','updated_at'];

    public function getCreatedAtAttribute($value)
    {
        return changeDateFormUTCtoLocal($this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute($value)
    {
        return changeDateFormUTCtoLocal($this->attributes['updated_at']);
    }




}
