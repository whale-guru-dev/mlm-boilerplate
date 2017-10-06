<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;

class UserAuthController extends Controller
{
    //
    public function login(Request $request)
    {

        $id = $request['username'];
        $password = $request['password'];

        $attempted_user = User::where('username', $id)->orWhere('email',$id)->first();

        if(!$attempted_user){

            return response()->json(['status' => 'fail', 'username' => $id, 'password' => $password]);
        }
        

        if (Hash::check( $password , $attempted_user->password))
        {

            return response()->json([ 'status' => 'success' ,'user' => $attempted_user ]);
        }

    }

    public function fblogin(Request $request)
    {
    	$email=$request['username'];

    	$attempted_user=User::where('email',$email)->first();

    	if($attempted_user)
    		return response()->json(['status'=>'success','user' => $attempted_user]);

    	return response()->json(['status'=>'fail','message'=>'unknown user']);
    }

    public function create(Request $request)
    {

        $user = User::where('username' , $request['username'])->first();

        if($user)
        	return response()->json(['status'=>'fail','message'=>'existing user']);
        $user=new User;
        $user['email']=$request['email'];
        $user['username']=$request['username'];
        $user['family_name']=$request['family_name'];
        $user['last_name']=$request['last_name'];
        $user['mobile']=$request['mobile'];
        $user['password']=bcrypt($request['password']);
        $user->save();

        return response()->json(['status'=>'success','message'=>'signup success']);
    }
}
