<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */
    private $job_number;
    /**
     * @var mixed|string
     */
    private $tag;
    /**
     * @var mixed
     */
    private $date;
    /**
     * @var mixed
     */
    private $product_id;
    /**
     * @var mixed
     */
    private $karigarh_id;
    /**
     * @var mixed
     */
    private $order_details_id;

    public function karigarh()
    {
        return $this->belongsTo('App\Models\Person','karigarh_id');
    }
    public function status_type()
    {
        return $this->belongsTo('App\Models\StatusType','status_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function order_detail()
    {
        return $this->belongsTo('App\Models\OrderDetail','order_details_id');
    }
    public function job_details(){
        return $this->hasMany(JobDetail::class, 'job_master_id');
    }


}
