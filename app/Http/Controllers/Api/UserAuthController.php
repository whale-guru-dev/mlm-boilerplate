<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserAuthController extends Controller
{
    //dfghdfgh
    public function login(Request $request)
    {

        $id = $request['username'];
        $password = $request['password'];

        $attempted_user = User::where('username', $id)->orWhere('email',$id)->first();

        if(!$attempted_user){

            return response()->json(['status' => 'fail', 'username' => $id, 'password' => $password]);
        }
        

        if( bcrypt($password) == $attempted_user->password)
        {
            return response()->json([ 'status' => 'success' ,'user' => $attempted_user ]);
        }

    }
}
