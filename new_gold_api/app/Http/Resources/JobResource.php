<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 *@property mixed user_name
 */
class JobResource extends JsonResource
{
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
            "user_name" => $this->user_name,
			"id" => $this->id,
			"date" => Carbon::parse($this->date)->format('d/m/Y'),
			"status_id" => $this->status_id,
			"job_number" => $this->job_number,
			"order_details_id" => $this->order_details_id,
			"karigarh_id" => $this->karigarh_id,
			"quantity" => $this->quantity,
			"size" => $this->size,
			"material_id" => $this->material_id,
			"product_id" => $this->product_id,
			"p_loss" => $this->p_loss,
			"model_number" => $this->model_number,
			"order_number" => $this->order_number,
			"date_of_delivery" => Carbon::parse($this->date_of_delivery)->format('d/m/Y'),
			"material_name" => $this->material_name
        ];
    }
}
