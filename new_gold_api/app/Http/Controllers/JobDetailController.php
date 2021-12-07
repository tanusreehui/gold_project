<?php

namespace App\Http\Controllers;

use App\Models\JobDetail;
use Illuminate\Http\Request;

class JobDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJobDetailsByJobAndMaterial($jobMasterId, $materialId)
    {
        $record = JobDetail::select('job_details.id','people.user_name','job_details.created_at','job_details.material_quantity')
            ->join('people','people.id','job_details.employee_id')
            ->where('job_details.job_master_id','=',$jobMasterId)
            ->where('job_details.material_id','=',$materialId)
            ->get();
        $data['record']=$record;
        $total_material = JobDetail::
                where('job_details.job_master_id','=',$jobMasterId)
                ->where('job_details.material_id','=',$materialId)
                ->sum('job_details.material_quantity');
        $data['total_material']=round($total_material,3);
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function show(JobDetail $jobDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(JobDetail $jobDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobDetail $jobDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobDetail $jobDetail)
    {
        //
    }
}
