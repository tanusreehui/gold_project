<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderResource extends JsonResource
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
            'person_id' => $this->person_id,
            'date_of_order' => Carbon::parse($this->date_of_order)->format('d/m/Y'),
            'date_of_delivery' => Carbon::parse($this->date_of_delivery)->format('d/m/Y'),
            'order_number' => $this->order_number,
            'cust_mv' => $this->cust_mv,
            'product_mv' => $this->product_mv,
            'discount' => $this->discount,
            'customer_name' => $this->customer_name,
            'billing_name' => $this->billing_name,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'customer_id' => $this->customer_id,
            'agent_id' => $this->agent_id,
            'agent_name' => $this->agent_name,
            'agent_short_name' => get_short_name($this->agent_name)
            ];
    }
}
