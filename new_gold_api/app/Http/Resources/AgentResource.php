<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user_name
 * @property mixed mobile1
 */
class AgentResource extends JsonResource
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
            'agentId' => $this->id,
            'agentName' => $this->user_name,
            'short_name' => get_short_name($this->user_name),
            'mobile'=>$this->mobile1
        ];
    }
}
