<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillableJobResource;
use App\Http\Resources\BillableOrderResource;
use App\Http\Resources\JobResource;
use App\Models\JobDetail;
use App\Models\JobMaster;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends ApiController
{
    public function getBillableCustomers(){
        $OrderDetailIds = JobMaster::whereStatusId(100)->pluck('order_details_id');
        $orderMasterIds = OrderDetail::whereIn('id',$OrderDetailIds)->distinct()->pluck('order_master_id');

        $order_details = OrderMaster::select('people.id',DB::raw('people.user_name as customer_name'),DB::raw('count(order_masters.order_number) as no_of_orders'))
                        ->join('people','people.id','order_masters.person_id')
                        ->groupBy('people.user_name')
                        ->whereIn('order_masters.id',$orderMasterIds)->get();
        return $this->successResponse($order_details);
    }
    public function getOrdersByCustomerId($id){
        $result = OrderMaster::select('order_masters.id'
                                        ,'created_at'
                                        ,'order_masters.order_number'
                                        ,'order_masters.agent_id'
                                        ,DB::raw('get_order_count_by_order_master_id(order_masters.id) as order_count')
                                        ,DB::raw('get_finished_job_count_by_order_master_id(order_masters.id) as finished_order_count')
                                        ,DB::raw('get_work_in_progress_job_count_by_order_master_id(order_masters.id) as wip_count')
                                        ,DB::raw('get_non_started_order_count_by_order_master_id(order_masters.id) as non_started_order_count')
                                        )
            ->wherePersonId($id)
            ->get();
        return $this->successResponse(BillableOrderResource::collection($result));
    }
    public function getJobsByOrderMasterId($orderMasterId){
        $order_details = OrderDetail::whereOrderMasterId($orderMasterId)->pluck('id');
        $jobs = JobMaster::whereIn('order_details_Id',$order_details)->get();
        return $this->successResponse(BillableJobResource::collection($jobs));
    }
}
