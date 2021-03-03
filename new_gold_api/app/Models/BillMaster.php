<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    public function getCustomer(){
        return $this->belongsTo('App\Models\People;','customer_id');

    }

    public function getBills(){
        return $this->hasMany('App\Models\BillMaster;','bill_master_id');
    }
}
