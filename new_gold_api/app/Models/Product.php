<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $fillable = ['model_number','product_name','product_category_id','price_code_id'];
    /**
     * @var mixed
     */
    private $model_number;

    protected $hidden = [
        "inforce","created_at","updated_at"
    ];

    protected $visible = ['id',
        'product_name',
        'model_number',
        'product_category_id',
        'price_code_id',
        'price_code_name',
        'category_name',
        'product_mv'];

    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory','product_category_id');
    }
    public function priceCode()
    {
        return $this->belongsTo('App\Models\PriceCode','price_code_id');
    }
}
