<?php

namespace App\Http\Controllers;

use App\Models\JobDetail;
use App\Models\JobMaster;
use Illuminate\Http\Request;

class BillController extends ApiController
{
    public function getBillableCustomers(){
        $jobMasterIds = JobMaster::whereStatusId(100)->pluck('order_details_id');
        $order_details = JobDetail::
                        join('order_masters','order_masters.id','order_details.order_master_id')
                        ->whereIn('job_details.id',$jobMasterIds)->get();
        return $this->successResponse($order_details);
    }
}
