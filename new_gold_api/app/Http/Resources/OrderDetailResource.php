<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'id' => $this->id,
            'order_master_id' => $this->order_master_id,
            'price' => $this->price,
            'price_code'=>$this->product->priceCode->price_code_name,
            'p_loss' => $this->p_loss,
            'approx_gold' => $this->approx_gold,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'material_id' => $this->material_id,
            'size' => $this->size,
            'product_id' => $this->product_id,
            'model_number'=>$this->product->model_number,
            'status_id' => $this->status_id,
            'bill_created' => $this->bill_created,
            'cust_mv' => $this->cust_mv,
            'product_mv' => $this->product_mv,
        ];
    }
}
