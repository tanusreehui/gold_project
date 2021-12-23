<?php

namespace App\Http\Controllers;

use App\Models\JobDetail;
use App\Models\JobMaster;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends ApiController
{
    public function getBillableCustomers(){
        $OrderDetailIds = JobMaster::whereStatusId(100)->pluck('order_details_id');
        $order_details = OrderDetail::select(DB::raw('people.user_name as customer_name'),DB::raw('count(order_masters.order_number) as no_of_orders'))
                        ->join('order_masters','order_details.order_master_id','order_masters.id')
                        ->join('people','people.id','order_masters.person_id')
                        ->groupBy('people.user_name')
                        ->whereIn('order_details.id',$OrderDetailIds)->get();
        return $this->successResponse($order_details);
    }
}
