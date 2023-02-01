<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as basec;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return $this->sendError('please fill the required data',$validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('awab')->accessToken; 
        $success['name'] = $user->name;
        return $this->sendResponse($success,'The user is account is registered successfully');

}

public function login(Request $request){
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        $success['token'] = $user->createToken('awab')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success,'The user is logged in successfully');
    }else{
        return $this->sendError('error in email or password',['error'=>'unautherized access']);
    }
    

}
}
