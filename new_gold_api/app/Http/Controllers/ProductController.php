<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Rate;

class ProductController extends Controller
{
    public function index()
    {
        $products=Product::select('products.id','product_name','products.model_number','products.product_category_id','products.price_code_id','price_codes.price_code_name','product_categories.category_name','products.product_mv')
            ->join('price_codes', 'price_codes.id', '=', 'products.price_code_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->get();


        return response()->json(['success'=>1,'data'=>$products], 200,[],JSON_NUMERIC_CHECK);
    }


    public function saveProduct(Request $request)
    {
        $product=new Product();
        $product->model_number=$request->input('model_number');
        $product->product_name=$request->input('product_name');
        $product->price_code_id=$request->input('price_code_id');
        $product->product_category_id=$request->input('product_category_id');
        $product->product_mv=$request->input('product_mv');
        $product->save();

        $product->setAttribute('category_name', $product->category->category_name);
        $product->setAttribute('price_code_name', $product->priceCode->price_code_name);

        return response()->json(['success'=>1,'data'=>$product], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateProduct(Request $request)
    {
        $product=new Product();
        $product=Product::find($request->input('id'));
        $product->model_number=$request->input('model_number');
        $product->product_name=$request->input('product_name');
        $product->price_code_id=$request->input('price_code_id');
        $product->product_category_id=$request->input('product_category_id');
        $product->product_mv=$request->input('product_mv');
        $product->update();

        $product->setAttribute('category_name', $product->category->category_name);
        $product->setAttribute('price_code_name', $product->priceCode->price_code_name);

        return response()->json(['success'=>1,'data'=>$product], 200,[],JSON_NUMERIC_CHECK);
    }


    public function deleteProduct(Request $request,$id)
    {
        $product = Product::find($id);
        $result=$product->delete();
//        return response()->json(['success'=>$result,'id'=>$id], 200);
        return response()->json(['success' => 1, 'data' => $result], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getProductData(Request $request)
    {
        $result= Rate::select('products.id','rates.price','rates.p_loss','price_codes.price_code_name','products.model_number','products.product_mv')
            ->join('products','rates.price_code_id','=','products.price_code_id')
            ->join('price_codes','price_codes.id','=','rates.price_code_id')
            ->where('rates.customer_category_id','=',$request['customer_category_id'])
            ->where('products.model_number','=',$request['model_number'])
            ->first();
        return response()->json(['success'=>1,'data'=>$result], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
