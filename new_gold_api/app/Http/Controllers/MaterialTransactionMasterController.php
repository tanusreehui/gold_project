<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransactionMaster;
use Illuminate\Http\Request;
use App\Models\MaterialTransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MaterialTransactionMasterController extends Controller
{
    public function saveTransaction(Request $request)
    {
        $input=($request->json()->all());

        $materialTransactionMaster=(object)($input['materialTransactionMaster']);
        $materialTransactionDetails=($input['materialTransactionDetails']);

        DB::beginTransaction();
        try {
            $transactionMaster = new MaterialTransactionMaster();
            $transactionMaster->transaction_type_id = $materialTransactionMaster->transaction_type_id;
            $transactionMaster->material_id = $materialTransactionMaster->material_id;
            $transactionMaster->transaction_comment = $materialTransactionMaster->transaction_comment;
            $transactionMaster->transaction_date = $materialTransactionMaster->transaction_date;
            $transactionMaster->save();

            if($transactionMaster){
                foreach ($materialTransactionDetails as $data){
                    $transactionDetails = new MaterialTransactionDetail();
                    $transactionDetails->transaction_masters_id = $transactionMaster->id;
                    $transactionDetails->employee_id = $data['employee_id'];
                    $transactionDetails->transaction_value = $data['transaction_value'];
                    $transactionDetails->quantity = $data['quantity'];
                    $transactionDetails->save();
                }
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['Success'=>1,'Exception'=>$e], 401);
        }

        return response()->json(['success'=>1, 'data'=> $transactionMaster],200,[],JSON_NUMERIC_CHECK);
    }

    public function getEmployees()
    {
        $data = User::select()
            ->where('user_type_id',2)
            ->orWhere('user_type_id',3)
            ->orWhere('user_type_id',4)
            ->orWhere('user_type_id',5)
            ->orWhere('user_type_id',6)
            ->get();
        return  response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Models\MaterialTransactionMaster  $materialTransactionMaster
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialTransactionMaster $materialTransactionMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialTransactionMaster  $materialTransactionMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialTransactionMaster $materialTransactionMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialTransactionMaster  $materialTransactionMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialTransactionMaster $materialTransactionMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialTransactionMaster  $materialTransactionMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialTransactionMaster $materialTransactionMaster)
    {
        //
    }
}
