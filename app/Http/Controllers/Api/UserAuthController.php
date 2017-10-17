<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use QrCode;

class UserAuthController extends Controller
{
    //
    public function login(Request $request)
    {
    	if($request){
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

    }

    public function fblogin(Request $request)
    {
    	if($request){
    	    	$email=$request['username'];
    	
    	    	$attempted_user=User::where('email',$email)->first();
    	
    	    	if($attempted_user)
    	    		return response()->json(['status'=>'success','user' => $attempted_user]);
    	
    	    	return response()->json(['status'=>'fail','message'=>'unknown user']);
    	    }
    }

    public function create(Request $request)
    {
    	if($request){
    	        $user = User::where('username' , $request['username'])->first();
    	
    	        if($user)
    	        	return response()->json(['status'=>'fail','message'=>'existing user']);
    	        $user=new User;

    	        
                if(User::where('email',$request['email']))
                     return response()->json(['status'=>'fail','message'=>'existing email']);
                $user['email']=$request['email'];
    	        
                if(User::where('username',$request['username']))
                     return response()->json(['status'=>'fail','message'=>'existing username']);
                $user['username']=$request['username'];
    	        $user['family_name']=$request['family_name'];
    	        $user['last_name']=$request['last_name'];
    	        $user['mobile']=$request['mobile'];
    	        $user['password']=bcrypt($request['password']);
    	        $user['qr_pass']=$qrLogin=bcrypt($request['username'].$request['email'].str_random(40));
                $user['join_date']=date('y-m-d');
    			QrCode::format('png')->color(38, 38, 38, 0.85)->backgroundColor(255, 255, 255, 0.82)->size(200)->generate(bcrypt($request['username'].$request['email'].str_random(40)),'qrcode/'.$request['username'].'.'.$request['email'].'.png');
    			$user['qr_path']=url('/').'/qrcode/'.$request['username'].'.'.$request['email'].'.png';
    			$user['refer_link']=url('/').'/referral/'.$request['username'];
    			$user->save();
    	        return response()->json(['status'=>'success','message'=>'signup success']);
    	    }
    }

    public function fbcreate(Request $request)
    {
    	if($request){
    	        $user = User::where('username' , $request['email'])->first();
    	
    	        if($user)
    	        	return response()->json(['status'=>'fail','message'=>'existing user']);

    	        $user=new User;

    	        
                if(User::where('email',$request['email']))
                    return response()->json(['status'=>'fail','message'=>'existing email']);
                $user['email']=$request['email'];
                
                if(User::where('username',$request['username']))
                     return response()->json(['status'=>'fail','message'=>'existing username']);
                $user['username']=$request['username'];
    	        $user['family_name']=$request['family_name'];
    	        $user['last_name']=$request['last_name'];
    	        $user['mobile']=$request['mobile'];
    	        $user['password']=bcrypt($request['password']);
                $user['qr_pass']=$qrLogin=bcrypt($request['username'].$request['email'].str_random(40));
                $user['join_date']=date('y-m-d');
                QrCode::format('png')->color(38, 38, 38, 0.85)->backgroundColor(255, 255, 255, 0.82)->size(200)->generate(bcrypt($request['username'].$request['email'].str_random(40)),'qrcode/'.$request['username'].'.'.$request['email'].'.png');
                $user['qr_path']=url('/').'/qrcode/'.$request['username'].'.'.$request['email'].'.png';
                $user['refer_link']=url('/').'/referral/'.$request['username'];
    	        $user['profile_photo']=$request['profile_photo'];
    	        $user->save();
    	
    	        return response()->json(['status'=>'success','message'=>'signup success']);
    	    }
    }
}
