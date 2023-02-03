<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\BaseController as basec;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(new ProductResource($products),'These are all of our products');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'details'=>'required|string',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return $this->sendError('please fill the required data',$validator->errors());
        }
        $input = $request->all();
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product),'The product was stored successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product),'The product was found successfully');
    }

    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'details'=>'required|string',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return $this->sendError('please fill the required data',$validator->errors());
        }
        $input = $request->all();
        $product = Product::find($id);
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->price = $input['price'];
        $product->save();
        return $this->sendResponse(new ProductResource($product),'The product was stored successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->destroy($id);
        return $this->sendResponse(new ProductResource($product),'The product was deleted successfully');
    }
}
