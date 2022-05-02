<?php

namespace App\Http\Resources;

use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed job_master_id
 * @property mixed size
 * @property mixed gross_weight
 * @property mixed material_id
 * @property mixed ginnie
 * @property mixed rate
 * @property mixed pure_gold
 * @property mixed quantity
 * @property mixed mv
 */
class BillDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $material = Material::find($this->material_id);
        return [
            'jobMasterId' => $this->job_master_id,
            'size' => $this->size,
            'grossWeight' => $this->gross_weight,
            'materialId' => $this->material_id,
//            'materialName'=>$material,
            'material_name'=>$material->material_name,
            'ginnie' => $this->ginnie,
            'rate' => $this->rate,
            'pureGold' => $this->pure_gold,
            'quantity' => $this->quantity,
            'mv' => $this->mv
        ];
    }
}
