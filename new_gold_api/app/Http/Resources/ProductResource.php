<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed model_number
 * @property mixed product_name
 * @property mixed product_category_id
 * @property mixed price_code_id
 * @property mixed product_mv
 * @property mixed priceCode
 */
class ProductResource extends JsonResource
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
            'id'=>$this->id,
            'model_number'=>$this->model_number,
            'product_name'=>$this->product_name,
            'product_category_id'=>$this->product_category_id,
            'price_code_id'=>$this->price_code_id,
            'product_mv'=>$this->product_mv,
            'priceCode' => new PriceCodeResource($this->priceCode)
        ];
    }
}
