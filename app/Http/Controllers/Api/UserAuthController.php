<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        

        if( bcrypt($password) == $attempted_user->password)
        {
            return response()->json([ 'status' => 'success' ,'user' => $attempted_user ]);
        }

    }

    public function create()
    {
 
        $data = request()->all();

        $client = User::where('username' , $data['username'])->first();

        if($client)
            return response()->json(['status' => 'fail']);

        $array = [
            'family_name' => $data['family_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ];

        if(isset($data['email']))
            $array['email'] = $data['email'];
        try{
        $user =  User::create($array);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['status' => 'fail']);
        }


        if($user)
            return response()->json(['status' => 'success']);

        return response()->json(['status' => 'fail']);

    }
}
