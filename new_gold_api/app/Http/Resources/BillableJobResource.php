<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed job_number
 * @property mixed karigarh_id
 * @property mixed updated_at
 * @property mixed created_at
 * @property mixed order_details_id
 * @property mixed date
 * @property mixed product_id
 * @property mixed tag
 * @property mixed status_id
 * @property mixed gross_weight
 * @property mixed product
 */
class BillableJobResource extends JsonResource
{
    /**
     * @var mixed
     */
    /**
     * @var mixed
     */



    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
           'jobId'=> $this->id,
            'jobNumber'=> $this->job_number,
            'tag'=> $this->tag,
            'jobDate'=> $this->date,
            'productId'=> $this->product_id,
            'product'=> $this->product,
            'karigarh'=> new KarigarhResource($this->karigarh),
            'OrderDetailsId'=> $this->order_details_id,
            'statusId'=> $this->status_id,
            'status' => $this->status_type,
            'isBillable' => $this->status_id==100,
            'grossWeight'=> $this->gross_weight,
            'isBillCreated'=> $this->bill_created,
            'customerMV'=> $this->cust_mv,
            'productMV'=> $this->product_mv,
            'ploss'=> $this->ploss,
            'quantity'=> $this->quantity,
			'price'=> $this->price,
            'isSelected' => $this->status_id==100,
			'createdAt'=> $this->created_at,
			'updatedAt'=> $this->updated_at
        ];
    }
}
