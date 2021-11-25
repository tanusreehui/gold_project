<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'user_name' => $this->user_name,
            'short_name'=>get_short_name($this->user_name),
            'billing_name' => $this->billing_name,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'user_type_id' => $this->user_type_id,
            'customer_category_id' => $this->customer_category_id,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'state' => $this->state,
            'area' => $this->area,
            'city' => $this->city,
            'pin' => $this->pin,
            'mv' => $this->mv,
            'opening_balance_LC' => $this->opening_balance_LC,
            'opening_balance_Gold' => $this->opening_balance_Gold,
            'discount' => $this->discount,
        ];
    }
}
