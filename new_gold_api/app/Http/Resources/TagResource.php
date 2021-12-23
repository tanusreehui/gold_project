<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'jobMasterId' => $this->id,
            'modelNumber' => (new ProductResource(Product::find($this->product_id)))->model_number,
            'jobNumber' => $this->job_number,
            'productId' => $this->product_id,
            'goldUsedForBill' => $this->gold_used_for_bill,
            'dalUsed' => $this->dal_used,
            'panUsedForBill' => $this->pan_used_for_bill,
            'nitricForBill' => $this->nitric_for_bill,
            'totalPloss' => $this->total_ploss,
            'totalCustMv' => $this-> total_cust_mv,
            'totalProductMv' => $this->total_product_mv,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'grossWeight' => $this->gross_weight,
            'goldWeight' => ($this->gold_used_for_bill
                            + $this->pan_used_for_bill
                            + $this->nitric_for_bill
                            + $this-> total_cust_mv
                            + $this->total_product_mv)
        ];
    }
}
