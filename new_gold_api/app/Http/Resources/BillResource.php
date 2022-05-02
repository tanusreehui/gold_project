<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'billMaster'=>new BillMasterResource($this['bill_master']),
//            'bill_details'=>$this['bill_details']
            'billDetails'=>BillDetailResource::collection($this['bill_details'])
//            'customer'=>new CustomerResource($this['customer']),
//            'job_details'=>JobDetailForBillResource::collection($this['job_details'])
        ];
    }
}
