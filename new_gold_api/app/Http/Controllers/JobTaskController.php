<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\JobTask;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\JobMaster;
use App\Models\JobDetail;
use Illuminate\Support\Facades\DB;


class JobTaskController extends Controller
{

    public function getSavedJobsForTag()
    {

        $data=JobMaster::select('people.user_name'
            ,'job_masters.id','job_masters.date'
            ,'job_masters.status_id'
            ,'job_masters.job_number'
            ,'job_masters.order_details_id'
            ,'job_masters.karigarh_id'
            ,'job_masters.date'
            ,'order_details.quantity'
            ,'order_details.size'
            ,'order_details.material_id'
            ,'order_details.product_id'
            ,'order_details.p_loss'
            ,'products.model_number'
            ,'order_masters.order_number'
            ,'order_masters.date_of_delivery'
            ,'materials.material_name'
            ,'products.model_number')
            ->join('order_details','job_masters.order_details_id','order_details.id')
            ->join('materials','order_details.material_id','materials.id')
            ->join('order_masters','order_details.order_master_id','=','order_masters.id')
            ->join('people','people.id','=','order_masters.person_id')
            ->join('products','order_details.product_id','=','products.id')
            ->where('job_masters.status_id','=',100)
            ->orderBy('job_masters.updated_at')
            ->get();

        return response()->json(['success'=>1,'data'=>JobResource::collection($data)], 200,[],JSON_NUMERIC_CHECK);

    }
    public function getSavedJobs()
    {
        $data=JobMaster::select('people.user_name'
            ,'job_masters.id','job_masters.date'
            ,'job_masters.status_id'
            ,'job_masters.job_number'
            ,'job_masters.order_details_id'
            ,'job_masters.karigarh_id'
            ,'job_masters.date'
            ,'order_details.quantity'
            ,'order_details.size'
            ,'order_details.material_id'
            ,'order_details.product_id'
            ,'order_details.p_loss'
            ,'products.model_number'
            ,'order_masters.order_number'
            ,'order_masters.date_of_delivery'
            ,'materials.material_name'
            ,'products.model_number')
            ->join('order_details','job_masters.order_details_id','order_details.id')
            ->join('materials','order_details.material_id','materials.id')
            ->join('order_masters','order_details.order_master_id','=','order_masters.id')
            ->join('people','people.id','=','order_masters.person_id')
            ->join('products','order_details.product_id','=','products.id')
            ->where('order_details.status_id','=',1)
            ->where('job_masters.status_id','=',1)
            ->orderBy('job_masters.updated_at')
            ->get();

        return response()->json(['success'=>1,'data'=>JobResource::collection($data)], 200,[],JSON_NUMERIC_CHECK);


    }

    public function getFinishedJobs()
    {
//        sleep(10);
        $data=JobMaster::select('people.user_name','job_masters.date','job_masters.id','job_masters.status_id','job_masters.job_number','job_masters.order_details_id','job_masters.karigarh_id','job_masters.date','job_masters.status_id','job_masters.bill_created','order_details.quantity','order_details.size','order_details.material_id','order_details.product_id','order_details.p_loss','products.model_number','order_masters.order_number','order_masters.date_of_delivery','materials.material_name','products.model_number')
            ->join('order_details','job_masters.order_details_id','order_details.id')
            ->join('materials','order_details.material_id','materials.id')
            ->join('order_masters','order_details.order_master_id','=','order_masters.id')
            ->join('people','people.id','=','order_masters.person_id')
            ->join('products','order_details.product_id','=','products.id')
            ->where('order_details.status_id','=',100)
            ->where('job_masters.status_id','=',100)
            ->orderBy('job_masters.updated_at')
            ->get();

        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }



    public function saveReturn(Request $request)
    {
        $input=$request->json()->all();
        $data=(object)($input['data']);

        $jobDetails=new JobDetail();
        $jobDetails->job_master_id= $data->id;
        $jobDetails->employee_id= $data->employee_id;
        $jobDetails->material_id=$data->material_id;
        $jobDetails->job_task_id=$data->job_Task_id;
        $jobDetails->material_quantity=$data->return_quantity;
        $jobDetails->save();

        return response()->json(['success'=>1,'data'=>$jobDetails], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getJobTaskData(Request $request){

        $input=$request->json()->all();
        $data=(object)($input['data']);

        $result = JobDetail:: select('job_details.id','job_details.job_master_id','job_details.employee_id','job_details.material_id','job_details.job_task_id','people.user_name','job_tasks.task_name',DB::Raw("abs(material_quantity) as material_quantity"),DB::raw("TIME(job_details.created_at) as time"),DB::raw(" DATE_FORMAT(job_details.created_at, \"%M %d %Y\") as date"))
            ->join('job_tasks','job_details.job_task_id','job_tasks.id')
            ->join('people','job_details.employee_id','people.id')
            ->where('job_details.job_task_id','=',$data->job_Task_id)
            ->where('job_details.job_master_id','=',$data->id)
            ->get();

        return response()->json(['success'=>1,'data'=> $result], 200,[],JSON_NUMERIC_CHECK);
    }
    public function getJobTaskDataByJobTaskIdAndJobMasterId($jobTasjId, $jobMasterId){
        $result = JobDetail:: select('job_details.id','job_details.job_master_id','job_details.employee_id','job_details.material_id','job_details.job_task_id','people.user_name','job_tasks.task_name',DB::Raw("abs(material_quantity) as material_quantity"),DB::raw("TIME(job_details.created_at) as time"),DB::raw(" DATE_FORMAT(job_details.created_at, \"%M %d %Y\") as date"))
            ->join('job_tasks','job_details.job_task_id','job_tasks.id')
            ->join('people','job_details.employee_id','people.id')
            ->where('job_details.job_task_id','=',$jobTasjId)
            ->where('job_details.job_master_id','=', $jobMasterId)
            ->get();

        return response()->json(['success'=>1,'data'=> $result], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getTotal(Request $request){

        $input=$request->json()->all();
        $data=(object)($input['data']);

        $total = JobDetail::select(DB::raw("abs(sum(job_details.material_quantity))  as total"),'job_tasks.task_name'
            ,  DB::raw('job_tasks.id as job_task_id')
            , 'job_details.job_master_id','job_masters.gross_weight')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->join('job_masters','job_masters.id','=','job_details.job_master_id')
            ->where('job_details.job_master_id','=',$data->id)
            ->groupBy('job_tasks.id')
            ->groupBy('job_details.job_master_id','job_tasks.task_name','job_masters.gross_weight')
            ->get();

        return response()->json(['success'=>1,'data'=> $total], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getJobSummarisationByJobMasterId($id){

//        $input=$request->json()->all();
//        $data=(object)($input['data']);

        $total = JobDetail::select(DB::raw("round(abs(sum(job_details.material_quantity)),3)  as total_material_quantity")
                    ,'job_tasks.task_name'
                    , DB::raw('job_tasks.id as job_task_id'))
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->join('job_masters','job_masters.id','=','job_details.job_master_id')
            ->where('job_details.job_master_id','=',$id)
            ->groupBy('job_tasks.id','job_tasks.task_name')
            ->get();

        return response()->json(['success'=>1,'data'=> $total], 200,[],JSON_NUMERIC_CHECK);
    }


    public function getAllTransactions($id){


        $result = JobDetail::select(DB::raw("abs(job_details.material_quantity)  as material_quantity"),DB::raw("TIME(job_details.created_at) as time"),DB::raw(" DATE_FORMAT(job_details.created_at, \"%M %d %Y\") as date"),'job_tasks.task_name', 'job_tasks.id', 'job_details.job_master_id','job_details.created_at','people.user_name')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->join('people','job_details.employee_id','people.id')
            ->where('job_details.job_master_id','=',$id)
            ->orderBy('job_details.created_at')
            ->get();

        return response()->json(['success'=>1,'data'=> $result], 200,[],JSON_NUMERIC_CHECK);
    }


    public function getOneJobData($id)
    {
        $data=JobMaster::select('order_details.approx_gold'
                        ,'people.user_name'
                        ,'job_masters.id'
                        ,'job_masters.status_id'
                        ,'job_masters.job_number'
                        ,'job_masters.order_details_id'
                        ,'job_masters.karigarh_id'
                        ,'job_masters.date'
                        ,'job_masters.gross_weight'
                        ,'order_details.quantity'
                        ,'order_details.size'
                        ,'order_details.material_id'
                        ,'order_details.product_id'
                        ,'order_details.p_loss'
                        ,'products.model_number'
                        ,'order_masters.order_number'
                        ,'order_masters.date_of_delivery'
                        ,'materials.material_name')
            ->join('order_details','job_masters.order_details_id','order_details.id')
            ->join('materials','order_details.material_id','materials.id')
            ->join('order_masters','order_details.order_master_id','=','order_masters.id')
            ->join('people','people.id','=','order_masters.person_id')
            ->join('products','order_details.product_id','=','products.id')
            ->where('job_masters.id','=',$id)
            ->first();

        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }


    public function countTaskBadgeValue($id)
    {
        $table1 = JobDetail::select()
            ->where('job_master_id',$id);

        $result = JobTask::select('job_tasks.id','job_tasks.task_name',DB::raw("count(table1.job_task_id) as badgeValue"))
            ->leftJoinSub($table1, 'table1', function ($join) {
                $join->on('job_tasks.id', '=', 'table1.job_task_id');
            })
            ->groupBy('table1.job_task_id','job_tasks.id','job_tasks.task_name')
            ->orderBy('job_tasks.id')
            ->get();

        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function show(JobTask $jobTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function edit(JobTask $jobTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTask $jobTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTask $jobTask)
    {
        //
    }
}
