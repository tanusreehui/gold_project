<?php

namespace App\Http\Resources;

use App\Models\Product;
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
                'product'=>new ProductResource(Product::find($this->product_id)),
				'gold_used_for_bill'=> round($this->gold_used_for_bill,3),
				'dal_used'=> round($this->dal_used,3),
				'pan_used_for_bill'=> round($this->pan_used_for_bill,3),
				'nitric_for_bill'=> round($this->nitric_for_bill,3),
				'total_ploss'=> round($this->total_ploss,3),
				'total_cust_mv'=> round($this->total_cust_mv,3),
				'total_product_mv'=> round($this->total_product_mv,3),
				'quantity'=> $this->quantity,
        ];
    }
}
