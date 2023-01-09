<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(4);
        

        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|string',
            'details' => 'required|string',
        ]);
        $post = Post::create($request->all());

        return redirect()->route('post.index',['success'=>'added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return view('post.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('post.edit', ["product"=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product->update($request->all());
        return redirect()->route('post.index', ['success' => 'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::onlyTrashed()->where('id',$id)->first()->forceDelete(); 
        return redirect()->route('products.index', ['success' => 'deleted successfully']);
    }
    public function softDelete($id)
    {
        $product = product::find($id)->delete();
        return redirect()->route('products.index', ['success' => 'deleted successfully']);
    }
    public function trashed()
    {
        $products = product::onlyTrashed()->latest()->paginate(4);
        return view('post.trash',compact('products'));
    }
    public function restore($id)
    {
        $product = product::onlyTrashed()->where('id',$id)->first()->restore(); 
        return redirect()->route('products.index', ['success' => 'deleted successfully']);
    }
}
