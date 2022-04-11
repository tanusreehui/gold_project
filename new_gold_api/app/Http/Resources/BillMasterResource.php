<?php

namespace App\Http\Resources;

use App\Models\Person;
use Carbon\Carbon;
use Cassandra\Custom;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed bill_number
 * @property mixed bill_date
 * @property mixed customer_id
 * @property mixed order_master_id
 * @property mixed agent_id
 * @property mixed discount
 * @property mixed created_at
 */
class BillMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $customer =Person::find($this->customer_id);
        $agent =Person::find($this->agent_id);
        return [
            'billNumber'=>$this->bill_number,
            'billDate'=>$this->bill_date,
            'billDateFormatted'=>Carbon::createFromFormat('Y-m-d', $this->bill_date)->format('d/m/Y'),
            'customerId'=>$this->customer_id,
            'customerName' =>$customer->user_name,
            'customerBillingName' => $customer->billing_name,
            'orderMasterId'=>$this->order_master_id,
            'agentId'=>$this->agent_id,
            'agentName'=>$agent->user_name,
            'discount'=>$this->discount,
            'createdAt'=>$this->created_at
            ];
    }
}
