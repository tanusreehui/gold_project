<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed job_number
 * @property mixed gold_used_for_bill
 * @property mixed dal_used
 * @property mixed pan_used_for_bill
 * @property mixed nitric_for_bill
 * @property mixed total_ploss
 * @property mixed total_cust_mv
 * @property mixed total_product_mv
 * @property mixed quantity
 */
class JobDetailForBillResource extends JsonResource
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
                'job_number'=>$this->job_number,
				'gold_used_for_bill'=> $this->gold_used_for_bill,
				'dal_used'=> $this->dal_used,
				'pan_used_for_bill'=> $this->pan_used_for_bill,
				'nitric_for_bill'=> $this->nitric_for_bill,
				'total_ploss'=> $this->total_ploss,
				'total_cust_mv'=> $this->total_cust_mv,
				'total_product_mv'=> $this->total_product_mv,
				'quantity'=> $this->quantity,
        ];
    }
}
