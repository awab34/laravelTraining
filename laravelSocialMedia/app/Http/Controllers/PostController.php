<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;

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
        $posts = Post::where('user_id',Auth::id())->get();
        

        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        if($tags->count() == 0){
            return redirect()->route('tag.create');
        }
        return view('post.create',compact('tags'));
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
            'tags' => 'required',
            'photo' => 'required|image',
        ]);
        
        $photo = $request->photo;
        $newPhoto = time().$photo->getClientOriginalName();
        $photo->move('uploads/posts',$newPhoto);
        $post = Post::create([
            'title'=>$request->title,
            'details'=>$request->details,
            'photo'=>'uploads/posts/'.$newPhoto,
            'user_id'=>Auth::id(),
            'slug'=>str_slug($request->title)
        ]);
        $post->tags()->attach($request->tags);
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
        $tags = Tag::all();
        $post = Post::find($id);
        return view('post.edit')->with('post',$post)->with('tags',$tags);
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
            'tags' => 'required',
            'photo'=>'image'
        ]);
        if($request->has('photo')){
            $photo = $request->photo;
            $photoToDelete =  public_path($post->photo);
            $newPhoto = time().$photo->getClientOriginalName();
            $result  = $photo->move('uploads/posts',$newPhoto);
            $post->photo = 'uploads/posts/'.$newPhoto;
            
            
            File::delete($photoToDelete);
        }
        $post->title = $request->title;
        $post->details = $request->details;
        $post->tags()->sync($request->tags);
        $post->save();
        return redirect()->route('posts', ['success' => 'updated successfully']);
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
        return redirect()->route('posts', ['success' => 'deleted successfully']);
    }
    public function hardDelete($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $photo =  public_path($post->photo);
        File::delete($photo);
        $post->forceDelete();

        return redirect()->back();
    }
    public function trashed()
    {
        // everybody can see it $posts = Post::onlyTrashed()->get();
        // only the on e who created it can see it
        $posts = Post::onlyTrashed()->where('user_id',Auth::id())->get();
        return view('post.trashed')->with('posts',$posts);
    }
    public function restore($id)
    {
        $posts = Post::onlyTrashed()->where('id',$id)->first()->restore(); 
        return redirect()->back();
    }
}
