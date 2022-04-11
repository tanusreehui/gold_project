<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    /**
     * @var mixed
     */
    private $order_master_id;

    public function getCustomer(){
        return $this->belongsTo('App\Models\People;','customer_id');

    }
    public function getCreatedAtAttribute($value): string
    {
        return changeDateFormUTCtoLocal($this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute($value): string
    {
        return changeDateFormUTCtoLocal($this->attributes['updated_at']);
    }
    public function getBills(){
        return $this->hasMany('App\Models\BillMaster;','bill_master_id');
    }
}
