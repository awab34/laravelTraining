<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $posts = Post::all();
        

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
            'title' => 'required|string',
            'details' => 'required|string',
            'photo' => 'required|image',
        ]);
        
        $photo = $request->photo;
        $newPhoto = time().$photo->getClientOriginalName();
        $photo->move('uploads/posts/'.$newPhoto);
        $post = Post::create([
            'title'=>$request->title,
            'details'=>$request->details,
            'photo'=>'uploads/posts/'.$newPhoto,
            'user_id'=>Auth::id(),
            'slug'=>str_slug($request->title)
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('post.edit',compact('post'));
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
        $post = Post::find($id);
        $request->validate([
            'title' => 'required|string',
            'details' => 'required|string',
        ]);
        if($request->has('photo')){
            $photo = $request->photo;
            $newPhoto = time().$photo->getClientOriginalName();
            $photo->move('uploads/posts/'.$newPhoto);
            $request->photo = 'uploads/posts/'.$newPhoto;
        }

        $post->update($request->all());
        return redirect()->route('post.index', ['success' => 'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function softDelete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('products.index', ['success' => 'deleted successfully']);
    }
    public function hardDelete($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $post = forceDelete();
        return redirect()->route('products.index', ['success' => 'deleted successfully']);
    }
    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return view('post.trashed')->with('posts',$posts);
    }
    public function restore($id)
    {
        $posts = Post::onlyTrashed()->where('id',$id)->first()->restore(); 
        return redirect()->route('products.index', ['success' => 'restored successfully']);
    }
}
