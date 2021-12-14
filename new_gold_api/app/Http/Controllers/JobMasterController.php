<?php

namespace App\Http\Controllers;

use App\Models\JobMaster;
use Illuminate\Http\Request;
use App\Models\BillAdjustment;
use App\Models\JobDetail;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use App\Models\CustomVoucher;

class JobMasterController extends Controller
{
    public function getJobs($id){
        $data = JobMaster::select()->where('job_number',$id)->first();
        return response()->json(['success'=>1,'data'=> $data], 200);
    }


    public function saveJob(Request $request)
    {
        $input=($request->json()->all());

        $inputJobMaster=(object)($input['master']);
        $inputJobDetails=(object)($input['details']);

        $temp_date = explode("-",$inputJobMaster->date);
        $accounting_year="";
        if($temp_date[1]>3){
            $x = $temp_date[0]%100;
            $accounting_year = $x*100 + ($x+1);
        }else{
            $x = $temp_date[0]%100;
            $accounting_year =($x-1)*100+$x;
        }

        $customVoucher=CustomVoucher::where('voucher_name',"job")->Where('accounting_year',$accounting_year)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name="job";
//            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
            $customVoucher->accounting_year=$accounting_year;
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='-';
            $customVoucher->prefix='JOB';
            $customVoucher->save();
        }

        $jobMaster= new JobMaster();
        $voucherNumber=$customVoucher->prefix
            .$customVoucher->delimiter
            .str_pad($customVoucher->last_counter,5,'0',STR_PAD_LEFT)
            .$customVoucher->delimiter
            .$customVoucher->accounting_year;
        $jobMaster->job_number=$voucherNumber;
        $jobMaster->date=$inputJobMaster->date;
        $jobMaster->karigarh_id=$inputJobMaster->karigarh_id;
        $jobMaster->order_details_id=$inputJobMaster->order_details_id;
//                $jobMaster->gross_weight=$inputJobMaster->gross_weight;
        $jobMaster->status_id=1;
        $jobMaster->quantity = $inputJobMaster->quantity;
        $jobMaster->cust_mv=$inputJobMaster->cust_mv;
        $jobMaster->product_mv=$inputJobMaster->product_mv;
        $jobMaster->ploss=$inputJobMaster->ploss;
        $jobMaster->price=$inputJobMaster->price;
        $jobMaster->save();

        $jobDetails=new JobDetail();
        $jobDetails->job_master_id=$jobMaster->id;
        $jobDetails->employee_id=$inputJobDetails->employee_id;
        $jobDetails->material_id=$inputJobDetails->material_id;
        $jobDetails->job_task_id=1;
        $jobDetails->material_quantity=$inputJobDetails->material_quantity;
        $jobDetails->save();

        if($jobDetails) {
            $orderDetails= new OrderDetail();
            $orderDetails=OrderDetail::find($inputJobMaster->order_details_id);
            $orderDetails->status_id=1;
            $orderDetails->update();

            $jobData = JobMaster::select('people.user_name','job_masters.id','job_masters.status_id','job_masters.job_number','job_masters.order_details_id','job_masters.karigarh_id','job_masters.date','order_details.quantity','order_details.size','order_details.material_id','order_details.product_id','order_details.p_loss','products.model_number','order_masters.order_number','order_masters.date_of_delivery','materials.material_name')
                ->join('order_details','job_masters.order_details_id','order_details.id')
                ->join('materials','order_details.material_id','materials.id')
                ->join('order_masters','order_details.order_master_id','=','order_masters.id')
                ->join('people','people.id','=','order_masters.person_id')
                ->join('products','order_details.product_id','=','products.id')
                ->where('job_masters.id',$jobMaster->id)
                ->first();
        }
        return response()->json(['success'=>1,'data'=> $jobData], 200);
    }

    public function updateGrossWeight(Request $request)
    {
        $input=($request->json()->all());
        $inputJobMaster=(object)($input['master']);
        $jobMaster = new JobMaster();
        $jobMaster = JobMaster::find($inputJobMaster->id);
        $jobMaster->gross_weight = $inputJobMaster->gross_weight;
        $jobMaster->update();
        if($jobMaster){
            $jobMaster->status_id =100;
            $jobMaster->update();

            $orderDetail = new OrderDetail();
            $orderDetail = OrderDetail::find($jobMaster->order_details_id);
            $orderDetail->status_id = 100;
            $orderDetail->update();
        }
        return response()->json(['success'=>1,'data'=> $jobMaster], 200);
    }

    public function  getTotalGoldSendById($id)
    {
        $totalGoldSend = JobDetail::select(DB::raw("sum(job_details.material_quantity) as total_gold_submit"))
            ->where('job_details.job_master_id',$id)
            ->where('job_details.job_task_id',1)
            ->first();

        return response()->json(['success'=>1,'data'=> $totalGoldSend], 200,[],JSON_NUMERIC_CHECK);

    }

    public function  getTotalGoldReturnById($id)
    {
        $totalGoldReturn = JobDetail::select(DB::raw("abs(sum(job_details.material_quantity))as total_gold_return"))
            ->where('job_details.job_master_id',$id)
            ->where('job_details.job_task_id',2)
            ->first();
        return response()->json(['success'=>1,'data'=> $totalGoldReturn], 200,[],JSON_NUMERIC_CHECK);
    }

    public function  getTotalPanSendById($id)
    {
        $totalPanSend = JobDetail::select(DB::raw("sum(job_details.material_quantity) as total_pan_submit"))
            ->where('job_details.job_master_id',$id)
            ->where('job_details.job_task_id',5)
            ->first();

        return response()->json(['success'=>1,'data'=> $totalPanSend], 200,[],JSON_NUMERIC_CHECK);

    }
    public function  getTotalPanReturnById($id)
    {
        $totalPanReturn = JobDetail::select(DB::raw("abs(sum(job_details.material_quantity))as total_pan_return"))
            ->where('job_details.job_master_id',$id)
            ->where('job_details.job_task_id',6)
            ->first();
        return response()->json(['success'=>1,'data'=> $totalPanReturn], 200,[],JSON_NUMERIC_CHECK);
    }

    public function  getTotalNitricReturnById($id)
    {
        $totalNitricReturn = JobDetail::select(DB::raw("abs(sum(job_details.material_quantity))as total_nitric_return"))
            ->where('job_details.job_master_id',$id)
            ->where('job_details.job_task_id',7)
            ->first();

        return response()->json(['success'=>1,'data'=> $totalNitricReturn], 200,[],JSON_NUMERIC_CHECK);

    }

    public function getBilledJobInfo($id)
    {
        $queryResult = DB::select('call getBilledJobInfo(?)',[$id]);
        $result1 = collect($queryResult);
//        return $result1[0]->user_name;

        $result2 = BillAdjustment::select()->get();
        $result4 = OrderDetail::select( 'materials.id','materials.material_name', 'materials.gold')
                   ->join('job_masters','job_masters.order_details_id','=','order_details.id')
                   ->join('materials','order_details.material_id','=','materials.id')
                   ->where('job_masters.id',$id)
                   ->first();

        $result3 = array(
            array("task_name"=>"Gold",
                "id"=>1,
                "submit"=>$result1[0]->material_submitted,
                "return"=>abs($result1[1]->material_submitted),
                "total"=> $result1[0]->material_submitted + $result1[1]->material_submitted,
                "valueTaken"=> 100,
                "rate" => $result1[0]->rate,
                "quantity" => $result1[0]->quantity,
                "mv" => $result1[0]->mv,
                "p_loss" => $result1[0]->p_loss,
                "model_number" => $result1[0]->model_number,
                "submit_employee_name" => $result1[0]->user_name,
                "return_employee_name" => $result1[1]->user_name,
            ),
            array("task_name"=>"Pan",
                "id"=>3,
                "submit"=>$result1[4]->material_submitted,
                "return"=>abs($result1[5]->material_submitted),
                "total"=> (($result1[4]->material_submitted + $result1[5]->material_submitted) * $result2[0]->value)/100,
                "valueTaken"=>$result2[0]->value,
                "submit_employee_name" => $result1[4]->user_name,
                "return_employee_name" => $result1[5]->user_name,
            ),
            array("task_name"=>"Nitric",
                "id"=>4,
                "submit"=> 0,
                "return"=>abs($result1[6]->material_submitted),
                "total"=>($result1[6]->material_submitted * $result2[1]->value)/100,
                "valueTaken"=>$result2[1]->value,
                "submit_employee_name" => "--",
                "return_employee_name" => $result1[6]->user_name,
            ),
            array("task_name"=>"Total PLoss",
                "id"=>0,
                "submit"=> "--",
                "return"=>"--",
                "total"=> $result1[0]->p_loss * $result1[0]->quantity ,
                "valueTaken"=>$result1[0]->p_loss

            ),
            array("task_name"=>"Total MV",
                "id"=>0,
                "submit"=> "--",
                "return"=>"--",
                "total"=> $result1[0]->mv * $result1[0]->quantity ,
                "valueTaken"=>  $result1[0]->mv

            )

        );
        return response()->json(['success'=>1,'data'=>$result3,'data2'=>$result4], 200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Models\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function show(JobMaster $jobMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(JobMaster $jobMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobMaster $jobMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobMaster $jobMaster)
    {
        //
    }
}
