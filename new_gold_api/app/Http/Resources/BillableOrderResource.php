<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed created_at
 * @property mixed order_number
 * @property mixed order_count
 * @property mixed finished_order_count
 * @property mixed wip_count
 * @property mixed non_started_order_count
 * @property mixed agent_id
 */
class BillableOrderResource extends JsonResource
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
            'orderMasterId' => $this->id,
			'createdAt' => $this->created_at,
			'orderNumber' => $this->order_number,
            'agent' => new AgentResource(Person::find($this->agent_id)),
			'orderCount' => $this->order_count,
			"finishedOrderCount"=> $this->finished_order_count,
			'WIPCount' => $this->wip_count,
			'nonStartedOrder_count' => $this->non_started_order_count
        ];
    }
}
