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
        $BaseControllerObject = new basec();
        return $BaseControllerObject->sendResponse(ProductResource::collection($products),'These are all of our products');
    }

    
    public function store(Request $request)
    {
        $BaseControllerObject = new basec();
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'details'=>'required|string',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return $BaseControllerObject->sendError('please fill the required data',$validator->errors());
        }
        $input = $request->all();
        $product = Product::create($input);
        return $BaseControllerObject->sendResponse(new ProductResource($product),'The product was stored successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $BaseControllerObject = new basec();
        $product = Product::find($id);
        if(is_null($product)){
            return $BaseControllerObject->sendError('Product not found');
        }
        return $BaseControllerObject->sendResponse(new ProductResource($product),'The product was found successfully');
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
        $BaseControllerObject = new basec();
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'details'=>'required|string',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return $BaseControllerObject->sendError('please fill the required data',$validator->errors());
        }
        $input = $request->all();
        $product = Product::find($id);
        if(is_null($product)){
            return $BaseControllerObject->sendError('Product not found');
        }
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->price = $input['price'];
        $product->save();
        return $BaseControllerObject->sendResponse(new ProductResource($product),'The product was stored successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BaseControllerObject = new basec();
        $product = Product::find($id);
        if(is_null($product)){
            return $BaseControllerObject->sendError('Product not found');
        }
        $product->destroy($id);
        return $BaseControllerObject->sendResponse(new ProductResource($product),'The product was deleted successfully');
    }
}
