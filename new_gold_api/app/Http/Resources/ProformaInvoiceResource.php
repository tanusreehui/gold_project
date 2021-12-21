<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProformaInvoiceResource extends JsonResource
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
            'order_master'=>$this['order_master'],
            'customer'=>new CustomerResource($this['customer']),
            'job_details'=>JobDetailForBillResource::collection($this['job_details'])
        ];
    }
}
