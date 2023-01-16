<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Profile;
class ProfileController extends Controller
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
        $user = Auth::user();
        $id =  Auth::id();
        if($user->profile == null){
            $profile = Profile::create([
                'province' => 'awab',
                'user_id' => $id,
                'gender' => 'Male',
                'bio' => 'Hi Awab',
                'facebook' => 'https://www.facebook.com'
            ]);
        }
        return view('users.profile',compact('user'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'province' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'bio' => 'required',
            'facebook' => 'required'
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->profile->province = $request->province;
        $user->profile->gender = $request->gender;
        $user->profile->bio = $request->bio;
        $user->profile->facebook = $request->facebook;
        $user->profile->save();
        $user->save();
        
        if($request->password != null){
            $user->password = bycrpt($request->password);
            $user->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
