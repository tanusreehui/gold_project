<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobMasterResource;
use App\Models\JobMaster;
use App\Models\Material;
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

    public function getJobSummaryByIdForBill($jobMasterId)
    {

        $gold_send_records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
            )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,1)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();
        $gold_send['records'] = $gold_send_records;

        $gold_send_actual=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,1)
            ->sum('job_details.material_quantity');
        $gold_send['actual_total'] = $gold_send_actual;


        $gold_send_billed=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,1)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $gold_send['bill_total'] = $gold_send_billed;

        $results['gold_send'] = $gold_send;
        /* GoOLD SEND COMPLETED */

        $gold_return_records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,2)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $gold_return['records'] = $gold_return_records;

        $gold_return_actual=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,2)
            ->sum('job_details.material_quantity');
        $gold_return['actual_total'] = round($gold_return_actual,3);

        $gold_return_billed=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,2)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $gold_return['bill_total'] = round($gold_return_billed,3);

        $results['gold_return'] = $gold_return;
        /* GoOLD RETURN COMPLETED */

        $pan_send_records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('round(job_details.material_quantity * materials.bill_percentage,3) as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,5)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $pan_send['records'] = $pan_send_records;

        $pan_send_actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,5)
            ->sum('job_details.material_quantity');
        $pan_send['actual_total'] = round($pan_send_actual_total,3);

        $pan_send_billed=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,5)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $pan_send['bill_total'] = round($pan_send_billed,3);

        $results['pan_send'] = $pan_send;
        /* PAN SEND COMPLETED */

        $records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,6)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $pan_return['records'] = $records;

        $actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,6)
            ->sum('job_details.material_quantity');
        $pan_return['actual_total'] = round($actual_total,3);

        $bill_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,6)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $pan_return['bill_total'] = round($bill_total,3);

        $results['pan_return'] = $pan_return;
        /* PAN RETURN COMPLETED */



        $records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,7)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $nitric_submit['records'] = $records;

        $actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,7)
            ->sum('job_details.material_quantity');
        $nitric_submit['actual_total'] = round($actual_total,3);

        $bill_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,7)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $nitric_submit['bill_total'] = round($bill_total,3);

        $results['nitric_return'] = $nitric_submit;
        /* NITRIC RETURN COMPLETED */


        $records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,3)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $dal_submit['records'] = $records;

        $actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,3)
            ->sum('job_details.material_quantity');
        $dal_submit['actual_total'] = round($actual_total,3);

        $bill_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,3)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $dal_submit['bill_total'] = round($bill_total,3);

        $results['dal_submit'] = $dal_submit;
        /* DAL SUBMIT COMPLETED */

        $records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,4)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $dal_return['records'] = $records;

        $actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,4)
            ->sum('job_details.material_quantity');
        $dal_return['actual_total'] = round($actual_total,3);

        $bill_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,4)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $dal_return['bill_total'] = round($bill_total,3);

        $results['dal_return'] = $dal_return;
        /* DAL RETURN COMPLETED */

        $records=JobDetail::select('materials.material_name'
            , 'people.user_name'
            , 'job_tasks.task_name'
            , 'job_details.material_quantity'
            , DB::raw('materials.bill_percentage * 100 as bill_percentage')
            , DB::raw('job_details.material_quantity * materials.bill_percentage as bill_quantity')
        )
            ->whereJobMasterIdAndJobTaskId($jobMasterId,8)
            ->join('materials','job_details.material_id','=','materials.id')
            ->join('people','job_details.employee_id','=','people.id')
            ->join('job_tasks','job_details.job_task_id','=','job_tasks.id')
            ->get();

        $bronze_submit['records'] = $records;

        $actual_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,8)
            ->sum('job_details.material_quantity');
        $bronze_submit['actual_total'] = round($actual_total,3);

        $bill_total=JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,8)
            ->join('materials','job_details.material_id','=','materials.id')
            ->sum(DB::raw('job_details.material_quantity * materials.bill_percentage'));
        $bronze_submit['bill_total'] = round($bill_total,3);

        $results['bronze_submit'] = $bronze_submit;
        /* BRONZE SUBMIT COMPLETED */

        $jobMaster = JobMaster::find($jobMasterId);
        $results['job_master'] = new JobMasterResource($jobMaster);

        $material_id = JobDetail::whereJobMasterIdAndJobTaskId($jobMasterId,1)->first()->material_id;
        $results['material'] =Material::find($material_id);


        $bill_gold_total =round(($results['gold_send']['bill_total'] + $results['gold_return']['bill_total'] + $results['pan_send']['bill_total'] + $results['pan_return']['bill_total'] + $results['nitric_return']['bill_total'] + ($results['job_master']['ploss'])*($results['job_master']['quantity']) +($results['job_master']['cust_mv']*$results['job_master']['quantity']) + ($results['job_master']['product_mv']*$results['job_master']['quantity'])),3);
        $results['bill_gold_total'] = $bill_gold_total;
        $results['bill_fine_total'] = $bill_gold_total * $results['material']['gold']/100;

        return response()->json(['success'=>1,'data'=>$results], 200,[],JSON_NUMERIC_CHECK);
    }

}
