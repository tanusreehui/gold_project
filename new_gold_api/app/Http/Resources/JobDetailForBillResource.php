<?php

namespace App\Http\Resources;

use App\Models\JobMaster;
use App\Models\Material;
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
 * @property mixed id
 * @property mixed product_id
 * @property mixed tag
 * @property mixed gross_weight
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
        $material = Material::find(JobMaster::find($this->id)->job_details->where('job_task_id','=',1)->first()->material_id);
        $fine_gold_percentage = $material->gold/100;
        $guinea_gold = round($this->gold_used_for_bill + $this->pan_used_for_bill +$this->total_ploss + $this->total_cust_mv + $this->total_product_mv + $this->nitric_for_bill,3);
        $fine_gold = round($guinea_gold * $fine_gold_percentage,3);
        $orderDetail = JobMaster::find($this->id)->order_detail;
        return [
                'job_master_id'=>$this->id,
                'tag' => $this->tag,
                'size' => $orderDetail->size,
                'gross_weight' =>$this->gross_weight,
                'price' => $orderDetail->price,
                'material'=>$material,
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
                'guinea_gold' => $guinea_gold,
                'fine_gold_percentage' => $fine_gold_percentage,
                'fine_gold' => $fine_gold,
                'gross_lc' => $orderDetail->price * $this->quantity
        ];
    }
}
