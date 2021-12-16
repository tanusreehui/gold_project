<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property mixed id
 * @property mixed job_number
 * @property mixed date
 * @property mixed karigarh_id
 * @property mixed order_details_id
 * @property mixed status_id
 * @property mixed gross_weight
 * @property mixed bill_created
 * @property mixed cust_mv
 * @property mixed product_mv
 * @property mixed ploss
 * @property mixed quantity
 * @property mixed price
 * @property mixed status_type
 */
class JobMasterResource extends JsonResource
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
            'job_number' => $this->job_number,
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'karigarh' => new KarigarhResource($this->karigarh),
            'order_details_id' => $this->order_details_id,
            'status_type' => $this->status_type,
            'status_id' => $this->status_id,
            'gross_weight' => $this->gross_weight,
            'bill_created' => $this->bill_created,
            'cust_mv' => $this->cust_mv,
            'product_mv' => $this->product_mv,
            'ploss' => $this->ploss,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
